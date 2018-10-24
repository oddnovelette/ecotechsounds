<?php

/* @var $this yii\web\View */
/* @var $model application\models\Blog\Post */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['post', 'slug' => $model->slug]);
?>

<div class="blog-posts-item">
    <?php if ($model->photo): ?>
        <div>
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($model->getThumbFileUrl('photo', 'blog_list')) ?>" alt="" class="img-responsive" />
            </a>
        </div>
    <?php endif; ?>
    <p class="post-title-list"><span style="background-color: #333"><a href="<?= Html::encode($url) ?>"><?= Html::encode($model->title) ?></a></span></p>
    <p class="post-date"><span style="background-color: #333"><span class="glyphicon glyphicon-cd"></span>
            <?= Yii::$app->formatter->format($model->created_at, 'relativeTime'); ?>
            in <?= Html::encode($model->category->name) ?> <?= Html::encode(strtoupper($model->language)) ?>&nbsp;&nbsp;
        <span class="glyphicon glyphicon-eye-open"></span> <?= $model->views_counter ?>
            <span class="glyphicon glyphicon-comment"></span> <?= $model->comments_counter ?>
                <span class="glyphicon glyphicon-heart"></span> <?= $model->likes_counter ?></span>
    </p>
    <p class="post-text-preview"><?= Yii::$app->formatter->asNtext($model->description) ?></p>
</div>
