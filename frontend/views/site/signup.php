<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \application\forms\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Create account', ['class' => 'btn btn-primary btn-lg', 'name' => 'signup-button']) ?>
                </div>
                <hr>
                <div style="color:#999;margin:1em 0">
                    Already have an account? <?= Html::a('Sign in', ['site/login']) ?>.
                </div>

                <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
