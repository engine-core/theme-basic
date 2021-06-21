<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

/* @var $this \yii\web\View */

/* @var $content string */

use EngineCore\Ec;
use EngineCore\extension\setting\SettingProviderInterface;
use EngineCore\widgets\FlashAlert;
use EngineCore\widgets\Issue;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$title = Ec::$service->getSystem()->getSetting()->get(SettingProviderInterface::SITE_TITLE);
$this->title = $title ? $title . ' - ' . $this->title : $this->title;
$this->title = Html::encode($this->title);

$this->beginContent('@EngineCore/themes/Basic/views/layouts/base.php');

echo Html::beginTag('div', [
    'id' => 'content-wrapper',
    'class' => 'container-fluid main'
]);

echo FlashAlert::widget();

echo Breadcrumbs::widget([
    'links' => $this->params['breadcrumbs'] ?? [],
]);

echo $content;

echo Issue::widget();

echo Html::endTag('div');

$this->endContent();