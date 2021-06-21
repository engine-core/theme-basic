<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

/* @var $this \yii\web\View */

/* @var $content string */

use EngineCore\Ec;
use EngineCore\enums\VisibleEnum;
use EngineCore\extension\repository\info\ExtensionInfo;
use EngineCore\extension\setting\SettingProviderInterface;
use EngineCore\themes\Basic\assetBundle\SiteAsset;
use EngineCore\themes\Basic\widgets\Nav;
use yii\helpers\Html;
use yii\bootstrap\NavBar;

SiteAsset::register($this);
$settingService = Ec::$service->getSystem()->getSetting();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php
    $this->registerMetaTag([
        'charset' => Yii::$app->charset,
    ]);
    $this->registerMetaTag([
        'http-equiv' => 'X-UA-Compatible',
        'content' => 'IE=edge',
    ]);
    $this->registerMetaTag([
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no',
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => Html::encode($settingService->get(SettingProviderInterface::SITE_DESCRIPTION)),
    ], 'description');
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => Html::encode($settingService->get(SettingProviderInterface::SITE_KEYWORD)),
    ], 'keywords');
    echo Html::csrfMetaTags();
    echo Html::tag('title', $this->title);

    $this->head();
    ?>
</head>
<body>

<?php $this->beginBody() ?>

<div class="wrap" id="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
        'innerContainerOptions' => [
            'class' => 'container-fluid',
        ],
    ]);
    // 导航菜单
    $menuItems = Ec::$service->getMenu()->getPage()->generateNavigation('backend', [
        Ec::$service->getMenu()->getConfig()->getProvider()->getVisibleField() => VisibleEnum::VISIBLE,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'titleField' => Ec::$service->getMenu()->getConfig()->getProvider()->getAliasField(),
        'dropdownTitleField' => Ec::$service->getMenu()->getConfig()->getProvider()->getAliasField(),
        'items' => $menuItems,
    ]);
    // 右侧菜单
    $rightMenuItems = [];
    if (Ec::$service->getExtension()->getRepository()->existsByCategory(ExtensionInfo::CATEGORY_PASSPORT)) {
        if (Yii::$app->user->isGuest) {
            $rightMenuItems[] = ['label' => 'Signup', 'url' => ['/passport/common/signup']];
            $rightMenuItems[] = ['label' => 'Login', 'url' => ['/passport/common/login']];
        } else {
            $rightMenuItems[] = '<li>'
                . Html::a('Logout (' . Yii::$app->user->identity->username . ')', ['/passport/common/logout'], [
                    'class' => 'btn btn-link logout',
                    'data-method' => 'post',
                ])
                . '</li>';
        }
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
    ]);
    NavBar::end();
    ?>

    <?= $content ?>

    <?= $this->render('_footer.php') ?>

</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
