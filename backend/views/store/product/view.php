<?php

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $product src\models\Store\Product */
/* @var $photosForm src\forms\Store\Product\PhotosForm */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-view">
    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $product->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">Store product info</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'label_id',
                                'value' => ArrayHelper::getValue($product, 'label.name'),
                            ],
                            'code',
                            'name',
                            'price',
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($product, 'category.name'),
                            ],
                            [
                                'label' => 'Tags',
                                'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name')),
                            ],
                        ],
                    ]) ?>
                    <br />
                </div>
            </div>
        </div>

    <div class="col-md-6">
    <div class="box">
        <div class="box-header with-border">Product Description</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($product->description) ?>
        </div>
    </div>
    </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Meta tags & SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $product,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'value' => $product->meta->title,
                    ],
                    [
                        'attribute' => 'meta.description',
                        'value' => $product->meta->description,
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'value' => $product->meta->keywords,
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box" id="photos">
        <div class="box-header with-border">Product Photos</div>
        <div class="box-body">
            <div class="row">
                <?php foreach ($product->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default btn-sm',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default btn-sm',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                $photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <div class="box" id="photos">
                <div class="box-body">
                    <ul class="list-group col-sm-12">
                        <li class="list-group-item disabled">Generated url`s</li>
                        <?php foreach ($product->photos as $photo): ?>
                            <li class="list-group-item">base id(<?= $photo->id ?>) <?= Html::a($photo->getUploadedFileUrl('file')) ?></li>
                            <li class="list-group-item"><span class="badge">preview</span>base id(<?= $photo->id ?>) <?= Html::a($photo->getThumbFileUrl('file')) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
        </div>
        <div class="clearfix"></div>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data'],
            ]); ?>
            <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>