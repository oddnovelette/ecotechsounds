<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \src\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the confirmation link below to continue registration:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
