<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 E-Kevin
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\themes\Basic;

use EngineCore\extension\repository\info\ThemeInfo;
use EngineCore\extension\setting\SettingProviderInterface;

class Info extends ThemeInfo
{
    
    protected $id = 'basic';
    
    /**
     * @inheritdoc
     */
    public function getSettings(): array
    {
        return array_merge(parent::getSettings(),[
            SettingProviderInterface::DEFAULT_THEME => [
                'value' => 'engine-core/theme-basic',
                'extra' => 'engine-core/theme-basic:engine-core/theme-basic',
            ],
        ]);
    }
    
}