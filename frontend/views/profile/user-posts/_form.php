<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model src\forms\Blog\PostForm */
/* @var $form yii\widgets\ActiveForm */
?>
<p>
    <?= Html::a('<i class="fa fa-chevron-left"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>
</p>
<div class="post-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Post info</div>
                <div class="panel-body">
                    <?= $form->field($model, 'categoryId')->dropDownList($model->categoriesList(), ['prompt' => '']) ?>

                    <?= $form->field($model, 'language')->dropDownList($model->languageList(), ['prompt' => '']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Tags</div>
                <div class="panel-body">
                    <div class="well" style="max-height: 100px; overflow: auto;">
                    <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList())->label('All tags') ?>
                    </div>
                    <?= $form->field($model->tags, 'textNew')->textInput(['placeholder' => 'tag1, tag2..'])->label('Type new tags for post') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
            <?= $form->field($model, 'content')->textarea(['rows' => 20]) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Photo</div>
        <div class="panel-body">
            <?= $form->field($model, 'photo')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                ]
            ]) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Meta tags & SEO</div>
        <div class="panel-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
            <?= $form->field($model->meta, 'keywords')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i> Save Post', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
