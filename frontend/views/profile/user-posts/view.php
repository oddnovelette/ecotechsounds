<?php

use src\helpers\PostHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post src\models\Blog\Post */

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
    <div class="panel panel-default">
        <div class="panel-heading">Post image</div>
        <div class="panel-body">
            <?php if ($post->photo): ?>
                <?= Html::a(Html::img($post->getThumbFileUrl('photo', 'thumb')), $post->getUploadedFileUrl('photo'), [
                    'class' => 'thumbnail',
                    'target' => '_blank'
                ]) ?>
            <?php endif; ?>
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
            <?= Yii::$app->formatter->asNtext($post->content) ?>
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
</div>
