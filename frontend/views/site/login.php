<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \application\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-5">
        <div class="site-login">

                <p>Please fill out the following fields to login:</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-log-in"></span> Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
                <hr>
                <div style="color:#999;margin:1em 0">
                    Forgot your password? You can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>
                <div style="color:#999;margin:1em 0">
                    Dont have a profile? <?= Html::a('Sign up', ['site/signup']) ?>.
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
