<?php
/**
 * @link https://github.com/engine-core/controller-backend-site
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

use EngineCore\Ec;
use EngineCore\extension\repository\info\ExtensionInfo;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $message string */
/* @var $name string */
/* @var $waitSecond integer */
/* @var $jumpUrl string */

// 是否存在通行证扩展
$hasPassportExtension = Ec::$service->getExtension()->getRepository()->existsByCategory(ExtensionInfo::CATEGORY_PASSPORT);
// 是否需要登录
$requiredLogin = $hasPassportExtension ? Yii::$app->getUser()->getIsGuest() : true;
$this->title = Yii::t('ec/app', 'Message prompt');
?>

<div class="row text-center">
    <div class="col-md-6 col-md-offset-3">
        <h1 style="font-size: 40px; margin-bottom: 20px;"><b><?= $name ?></b></h1>

        <p><?= \yii\helpers\HtmlPurifier::process($message) ?></p>

        <p class="text-muted">
            <small>
                <?php
                echo Yii::t('ec/app',
                    'After a few seconds the page will automatically jump.',
                    ['seconds' => '<b id="wait">' . ($waitSecond ?: 3) . '</b> ']);
                echo Html::a(' ' . Yii::t('ec/app', 'Stop to jump.'), null, [
                    'onclick' => 'stopJumpUrl();',
                    'data-no-pjax' => '',
                    'role' => 'button',
                ]);
                ?>
            </small>
        </p>

        <div class="row">
            <div class="col-md-6">
                <?php
                if ($hasPassportExtension && $requiredLogin) {
                    echo Html::a(Yii::t('ec/app', 'Login again.'), Yii::$app->getUser()->loginUrl, [
                        'class' => 'btn btn-success btn-block',
                    ]);
                } else {
                    echo Html::a(Yii::t('ec/app', 'Return home.'), ['/'], [
                        'class' => 'btn btn-success btn-block',
                    ]);
                }
                ?>
            </div>
            <div class="col-md-6">
                <?= Html::a(Yii::t('ec/app', 'Jump to url.'), $jumpUrl, [
                    'id' => 'href',
                    'class' => 'btn btn-primary btn-block',
                ]) ?>
            </div>
        </div>
    </div>
</div>