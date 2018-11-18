<?php

use kartik\file\FileInput;
use src\helpers\PostHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post src\models\Blog\Post */
/* @var $photosForm src\forms\Blog\PhotosForm */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['posts']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <p>
        <?= Html::a('<i class="fa fa-chevron-left"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-plus"></i> Create Post', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php if ($post->published()): ?>
            <?= Html::a('<i class="fa fa-times"></i> Unpublish', ['draft', 'id' => $post->id], ['class' => 'btn btn-warning', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('<i class="fa fa-check"></i> Publish', ['publish', 'id' => $post->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('<i class="fa fa-pencil"></i> Update', ['update', 'id' => $post->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $post->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this post?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Post info</div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $post,
                        'attributes' => [
                            'id',
                            'slug',
                            [
                                'attribute' => 'status',
                                'value' => PostHelper::statusLabel($post->status),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'lang',
                                'value' => PostHelper::languageLabel($post->language),
                                'format' => 'raw',
                            ],
                            'title',
                            [
                                'label' => 'Category',
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($post, 'category.name'),
                            ],
                            [
                                'label' => 'Tags',
                                'value' => implode(', ', ArrayHelper::getColumn($post->tags, 'name')),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Shown image (thumbnail)</div>
                <div class="panel-body">

                    <?php if ($post->mainPhoto): ?>
                        <p>
                            <img src="<?= Html::encode($post->mainPhoto->getThumbFileUrl('file', 'origin')) ?>"
                                alt="<?= Html::encode($post->title) ?>"
                                class="img img-responsive img-rounded" style="margin: 0 auto;" />
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Short Description</div>
        <div class="panel-body">
            <?= Yii::$app->formatter->asNtext($post->description) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Content</div>
        <div class="panel-body">
            <?= Yii::$app->formatter->asHtml($post->content, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Meta tags & SEO</div>
        <div class="panel-body">
            <?= DetailView::widget([
                'model' => $post,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'value' => $post->meta->title,
                    ],
                    [
                        'attribute' => 'meta.description',
                        'value' => $post->meta->description,
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'value' => $post->meta->keywords,
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="panel panel-default" id="photos">
        <div class="panel-heading">Post Photos (Max 3 images for post will be shown)</div>
        <div class="panel-body">
            <div class="row">
                <?php foreach ($post->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $post->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default btn-sm',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<i class="fa fa-times"></i>', ['delete-photo', 'id' => $post->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $post->id, 'photo_id' => $photo->id], [
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

            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data'],
            ]); ?>
            <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
