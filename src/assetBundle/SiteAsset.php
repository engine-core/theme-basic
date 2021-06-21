<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\themes\Basic\assetBundle;

use Yii;
use yii\web\AssetBundle;

/**
 * Class SiteAsset
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class SiteAsset extends AssetBundle
{
    
    public $sourcePath = '@EngineCore/themes/Basic/assets';
    
    public $css = [
        'css/site.css',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];

    public function init()
    {
        parent::init();

        $this->registerJumpUrlJs();
    }

    protected function registerJumpUrlJs()
    {
        $js = <<<JS
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;

        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            }
        }, 1000);
        window.stopJumpUrl = function (){
            clearInterval(interval);
        }
JS;
        $view = Yii::$app->getView();
        $view->registerJs($js);
    }
    
}