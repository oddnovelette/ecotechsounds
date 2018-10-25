<?php

/* @var $this yii\web\View */
/* @var $user \src\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>
    Hello <?= $user->username ?>,
    Follow the confirmation link below to continue registration:

<?= $confirmLink ?>
