<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 E-Kevin
 * @license BSD 3-Clause License
 */

namespace EngineCore\themes\Basic\assetBundle;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle
{
    
    public $sourcePath = '@EngineCore/themes/Basic/assets';
    
    public $css = [
        'css/site.css',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\widgets\PjaxAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
    
}