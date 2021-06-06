<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\themes\Basic\assetBundle;

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
        'yii\widgets\PjaxAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
    
}