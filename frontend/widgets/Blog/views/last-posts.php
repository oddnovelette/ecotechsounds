<?php

/** @var $posts src\models\Blog\Post[] */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <?php $url = Url::to(['/blog/post/post', 'id' => $post->id]); ?>
        <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <?php if ($post->photo): ?>
                    <div class="image">
                        <a href="<?= Html::encode($url) ?>">
                            <img src="<?= Html::encode($post->getThumbFileUrl('photo', 'widget_list')) ?>" alt="" class="img-responsive" />
                        </a>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="caption">
                        <p class="widget-posts"><a href="<?= Html::encode($url) ?>"><?= Html::encode($post->title) ?></a></p>

                        <p><?= Html::encode(StringHelper::truncateWords(strip_tags($post->description), 25)) ?></p>

                        <p class="post-date">&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-eye-open"></span> <?= $post->views_counter ?>
                                <span class="glyphicon glyphicon-comment"></span> <?= $post->comments_counter ?>
                                <span class="glyphicon glyphicon-heart"></span> <?= $post->likes_counter ?>
                        </p>
                    </div>
                </div>

        </div>
    <?php endforeach; ?>
</div>
