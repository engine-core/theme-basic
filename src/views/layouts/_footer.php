<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 E-Kevin
 * @license BSD 3-Clause License
 */

use yii\helpers\Html;

?>

<footer class="footer text-muted">
    <p class="pull-left">
        <?= Yii::t('ec/app', 'Copyright {date} by {company}',
            [
                'date'    => Yii::$app->params['app.copyright'],
                'company' => Yii::$app->params['app.name'],
            ]
        ); ?>
    </p>

    <p class="pull-right">
        <?= Yii::t('ec/app',
            'Technical support by {company}',
            [
                'company' => Html::a('EngineCore', 'https://github.com/e-kevin/engone-core', [
                    'target' => '_blank',
                ]),
            ]
        ) ?>
    </p>
</footer>
