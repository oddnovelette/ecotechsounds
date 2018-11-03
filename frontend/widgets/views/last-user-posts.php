<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $user src\models\User */
/* @var $posts src\models\Blog\Post[] */

?>
<div class="last-user-posts">
    <?php if (count($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h1><?= Html::a(Html::encode($post->title), ['/blog/post/post', 'slug' => $post->slug]) ?></h1>
                </div>
                <div class="panel-body">
                    <?php if ($post->photo): ?>
                        <div class="lefter-thumb">
                            <img src="<?= Html::encode($post->getThumbFileUrl('photo', 'widget_list')) ?>" alt="" class="img-responsive img-rounded" />
                        </div>
                    <?php endif; ?>

                    <p class="post-text-list"><?= Yii::$app->formatter->asNtext(StringHelper::truncateWords($post->content, 100)) ?></p>
                </div>

                <div class="panel-footer">
                <span class="post-date-lite">
        <span class="glyphicon glyphicon-eye-open"></span> <?= $post->views_counter ?>
                        <span class="glyphicon glyphicon-comment"></span> <?= $post->comments_counter ?>
                        <span class="glyphicon glyphicon-heart"></span> <?= $post->likes_counter ?>
                </span>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><strong><i>It is empty here by the moment..</i></strong></p>
    <?php endif; ?>
</div>
