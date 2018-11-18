<?php

use kartik\widgets\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model src\models\User */

$this->title = 'Profile Settings';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['profile/user/view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile/user/view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update col-sm-10">

    <?php $form = ActiveForm::begin(); ?>
    <h2>Your profile display settings</h2><hr>
    <div class="row">
        <div class="col-sm-6">
    <?= $form->field($model, 'username')->textInput(['disabled' => true])->label('') ?>
        </div>
        <div class="col-sm-6">
    <?= $form->field($model, 'user_from')->textInput(['placeholder' => 'From'])->label('Your location') ?>
        </div>
    </div><hr>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'real_name')->textInput()->label('First name') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'real_surname')->textInput()->label('Last name') ?>
        </div>
    </div>

    <div class="row well">
        <p>Your image. Note, that it will be optimized by size.
        </p>
        <div class="col-sm-6">
        <?php if ($user->avatar): ?>
            <?= Html::img($user->getThumbFileUrl('avatar', 'list'), ['class' => 'img-circle img-responsive']) ?>
        <?php endif; ?>
        </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'avatar')->label('Change image')->widget(FileInput::class, [
            'options' => [
                'accept' => 'image/*',
            ],
            'pluginOptions' => [
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            ]
        ]) ?>
        </div>
    </div><hr>

    <div class="row">
        <div class="col-sm-6">
    <?= $form->field($model, 'description')->textarea(['rows' => 10])->label('Bio (Text without formatting, 255 chars.)') ?>
        </div>

     <div class="col-sm-6">
    <p><span class="fa fa-chain"></span> Your additional links</p>

    <?= $form->field($model, 'soundcloud_link')->textInput(['placeholder' => 'Soundcloud'])->label(false) ?>
    <?= $form->field($model, 'bandcamp_link')->textInput(['placeholder' => 'Bandcamp'])->label(false) ?>
    <?= $form->field($model, 'discogs_link')->textInput(['placeholder' => 'Discogs'])->label(false) ?>
     </div>
    </div>
    <hr>

    <div class="form-group">
        <?= Html::submitButton('Save changes', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
