<?php

/** @var $posts src\models\Blog\Post[] */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <?php $url = Url::to(['/blog/post/post', 'slug' => $post->slug]); ?>
        <div class="post-layout col-lg-4 col-md-4 col-sm-6 col-xs-12">

                <?php if ($post->photo): ?>
                    <div class="image">
                        <a href="<?= Html::encode($url) ?>">
                            <img src="<?= Html::encode($post->getThumbFileUrl('photo', 'widget_list')) ?>" alt="" class="img-responsive" />
                        </a>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="caption">
                        <h3 class="widget-posts"><a href="<?= Html::encode($url) ?>">
                                <?= Html::encode('['.$post->category->name.'] ') ?>

                                <?= Html::encode(StringHelper::truncateWords(strip_tags($post->title), 5)) ?></a></h3>

                        <p class="post-text-preview"><?= Html::encode(StringHelper::truncateWords(strip_tags($post->description), 15)) ?></p>
                    </div>
                </div>

        </div>
    <?php endforeach; ?>
</div>
