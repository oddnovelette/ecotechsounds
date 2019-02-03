<?php

/* @var $this yii\web\View */
/* @var $model src\forms\User\UserEditForm */
/* @var $user src\models\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update User: ' . $user->username . ' (base id #'. $user->id .')';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?><hr>

<div class="row col-md-5 col-md-offset-3">
    <div class="box">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
            <?= $form->field($model, 'role')->dropDownList($model->rolesList()) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
