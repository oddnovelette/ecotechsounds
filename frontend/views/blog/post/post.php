<?php

/* @var $this yii\web\View */
/* @var $post application\models\Blog\Post */

use frontend\widgets\Blog\BlogCommentsWidget;
use yii\helpers\Html;

$this->title = $post->getSeoTitle();
$this->registerMetaTag(['name' =>'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $post->meta->keywords]);
$this->params['breadcrumbs'][] = ['label' => 'Magazine', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->category->name, 'url' => ['category', 'slug' => $post->category->slug]];
$this->params['breadcrumbs'][] = $post->title;
$this->params['active_category'] = $post->category;
$tagLinks = [];

foreach ($post->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode('#'.$tag->name), ['tag', 'slug' => $tag->slug]);
}
?>
<article xmlns="http://www.w3.org/1999/html">
    <p class="post-title"><span style="background-color: #333"><?= Html::encode($post->title) ?></span></p>
    <p class="post-date"><span style="background-color: #333"><span class="glyphicon glyphicon-cd"></span>
            <?= Yii::$app->formatter->format($post->created_at, 'relativeTime'); ?>
            in <?= Html::encode($post->category->name) ?> <?= Html::encode(strtoupper($post->language)) ?>&nbsp;&nbsp;
        <span class="glyphicon glyphicon-eye-open"></span> <?= $post->views_counter ?>
        <span class="glyphicon glyphicon-comment"></span> <?= $post->comments_counter ?></span>
    </p>
    <?php if ($post->photo): ?>
        <p><img src="<?= Html::encode($post->getThumbFileUrl('photo', 'origin')) ?>" alt="" class="img-responsive" /></p>
    <?php endif; ?>

    <p class="post-text"><?= Yii::$app->formatter->asNtext($post->content) ?></p>
</article>

<div class="row post-credentials">
    <div class="col-md-6">
        Like <a href="#" class="glyphicon glyphicon-heart-empty like btn btn-lg" data-id="<?=$post->id?>"></a>
    </div>

    <div class="col-md-6">
    <div class="author">By <?= Html::encode($post->user->username) ?></div>
    </div>

</div>
<div class="clearfix"></div><br>
<p>Tags: <?= implode(', ', $tagLinks) ?></p>

<?= BlogCommentsWidget::widget(['post' => $post]) ?>

<?php $this->registerJs("
    $(document).ready(function () {
    $('a.like').click(function () { 
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };        
        $.post('/blog/post/like', params, function(data) {
            if (data.success) {
                button.hide();
                button.siblings('.button-unlike').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
        });
        return false;
    });

    $('a.button-unlike').click(function () { 
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };        
        $.post('/blog/post/unlike', params, function(data) {
            if (data.success) {
                button.hide();
                button.siblings('.button-like').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
        });
        return false;
    });
});

"); ?>
