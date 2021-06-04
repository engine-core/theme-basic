<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 E-Kevin
 * @license BSD 3-Clause License
 */

/* @var $this \yii\web\View */
/* @var $content string */

use EngineCore\widgets\FlashAlert;
use EngineCore\widgets\Issue;
use yii\widgets\Breadcrumbs;

$layouts = '@EngineCore/themes/Basic/views/layouts/';
$this->beginContent($layouts . 'base.php');
?>

<div class="container-fluid">
    <div class="main">
        <?= FlashAlert::widget() ?>
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
        <?= $content ?>
        <?= Issue::widget() ?>
    </div>
</div>
<?= $this->render($layouts . '_footer.php') ?>

<?php $this->endContent(); ?>
