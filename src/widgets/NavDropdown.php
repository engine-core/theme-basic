<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 E-Kevin
 * @license BSD 3-Clause License
 */

namespace EngineCore\themes\Basic\widgets;

use rmrevin\yii\fontawesome\FA;
use yii\base\InvalidConfigException;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/**
 * Theme NavDropdown widget.
 */
class NavDropdown extends Dropdown
{
    
    /**
     * @var string 用于菜单显示的字段名
     */
    public $titleField = 'label';
    
    /**
     * @inheritdoc
     */
    protected function renderItems($items, $options = [])
    {
        $lines = [];
        $count = count($items);
        $i = 1;
        foreach ($items as $item) {
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if ((isset($item['visible']) && !$item['visible']) ||
                // 生产环境下过滤开发环境下的菜单
                (isset($item['visible_on_dev']) && (YII_ENV_PROD || !$item['visible_on_dev']))
            ) {
                continue;
            }
            if (!array_key_exists('label', $item) && !array_key_exists('alias', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $icon = '';
            if (isset($item['icon'])) {
                $icon = $item['icon'] ? FA::i($item['icon']) : FA::i('circle-o');
            }
            $encodeLabel = $item['encode'] ?? $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item[$this->titleField]) : $item[$this->titleField];
            $label = $icon . Html::tag('span', $label);
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            if (isset($item['config'])) {
                if ($tmp = ArrayHelper::getValue($item, 'config.options', [])) {
                    $itemOptions = $tmp;
                }
                if ($tmp = ArrayHelper::getValue($item, 'config.linkOptions', [])) {
                    $linkOptions = $tmp;
                }
            }
            $linkOptions['tabindex'] = '-1';
            if (isset($item['url'])) {
                $url = isset($item['params']) && is_array($item['params']) ?
                    array_merge([$item['url']], $item['params']) :
                    $item['url'];
            } else {
                $url = null;
            }
            if (empty($item['items'])) {
                if ($url === null) {
                    $content = $label;
                    Html::addCssClass($itemOptions, ['widget' => 'dropdown-header']);
                } else {
                    $content = Html::a($label, $url, $linkOptions);
                }
            } else {
                $lines[] = Html::tag('li', $label, ['class' => 'dropdown-header']);
                $submenuOptions = $this->submenuOptions;
                if (isset($item['submenuOptions'])) {
                    $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
                }
                $content = $this->renderItems($item['items'], $submenuOptions);
                Html::addCssClass($itemOptions, ['widget' => 'dropdown-submenu']);
            }
            
            $lines[] = Html::tag('li', $content, $itemOptions);
            if (!empty($item['items']) && $count > 1) {
                if ($i !== $count) {
                    $lines[] = Html::tag('li', '', ['class' => 'divider']);
                }
            }
            $i++;
        }
        
        return Html::tag('ul', implode("\n", $lines), $options);
    }
    
}
