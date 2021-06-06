<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\themes\Basic\widgets;

use rmrevin\yii\fontawesome\FA;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\bootstrap\Nav as baseNav;
use yii\helpers\ArrayHelper;

/**
 * Class Nav
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Nav extends baseNav
{
    
    /**
     * @var string 用于菜单显示的字段名
     */
    public $titleField = 'label';
    
    public $dropdownClass = 'EngineCore\themes\Basic\widgets\NavDropdown';
    
    /**
     * @var string 用于dropdown小部件菜单显示的字段名
     */
    public $dropdownTitleField = 'label';
    
    /**
     * @inheritdoc
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label']) && !isset($item['alias'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $icon = '';
        if (isset($item['icon'])) {
            $icon = $item['icon'] ? FA::i($item['icon']) : FA::i('circle-o');
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item[$this->titleField]) : $item[$this->titleField];
        $label = $icon . Html::tag('span', $label);
        $options = ArrayHelper::getValue($item, 'options', []);
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        
        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }
        
        if (empty($items)) {
            $items = '';
        } else {
            $linkOptions['data-toggle'] = 'dropdown';
            Html::addCssClass($options, ['widget' => 'dropdown']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                $items = $this->isChildActive($items, $active);
                $items = $this->renderDropdown($items, $item);
            }
        }
        
        if ($active) {
            Html::addCssClass($options, 'active');
        }
        
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDropdown($items, $parentItem)
    {
        /** @var Widget $dropdownClass */
        $dropdownClass = $this->dropdownClass;
        
        return $dropdownClass::widget([
            'options'       => ArrayHelper::getValue($parentItem, 'dropDownOptions', []),
            'items'         => $items,
            'encodeLabels'  => $this->encodeLabels,
            'clientOptions' => false,
            'view'          => $this->getView(),
            'titleField'    => $this->dropdownTitleField,
        ]);
    }
    
}
