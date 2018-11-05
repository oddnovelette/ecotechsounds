<?php

/* @var $this yii\web\View */
/* @var $post src\models\Blog\Post */

use frontend\widgets\Blog\BlogCommentsWidget;
use frontend\widgets\Blog\LastPostsWidget;
use src\models\User;
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
    <p class="post-title"><?= Html::encode($post->title) ?></p>
    <p class="post-date"><span><span class="glyphicon glyphicon-cd"></span>
            <?= Yii::$app->formatter->format($post->created_at, 'relativeTime'); ?>
            in <?= Html::encode($post->category->name) ?> <?= Html::encode(strtoupper($post->language)) ?>&nbsp;&nbsp;
        <span class="glyphicon glyphicon-eye-open"></span> <?= $post->views_counter ?>
        <span class="glyphicon glyphicon-comment"></span> <?= $post->comments_counter ?>
        <span class="glyphicon glyphicon-heart"></span> <?= $post->likes_counter ?></span>
    </p>

    <?php if ($post->photo): ?>
        <p><img src="<?= Html::encode($post->getThumbFileUrl('photo', 'origin')) ?>" alt="" class="img-responsive" /></p>
    <?php endif; ?>

    <p class="post-text"><?= Yii::$app->formatter->asNtext($post->content) ?></p>
</article>

<div class="row post-credentials">
    <div class="col-md-6">
        <div class="col-md-6">

                <a href="#" data-id="<?= $post->id ?>" class="btn btn-sm button-unlike <?=(User::findIdentity(Yii::$app->user->id) and !User::findIdentity(Yii::$app->user->id)->postAlreadyLiked($post->id)) ? "" : "hidden";?>">
                <span class="glyphicon glyphicon-heart"></span>
                </a>

                <a href="#" data-id="<?= $post->id ?>" class="btn btn-sm button-like <?=(User::findIdentity(Yii::$app->user->id) and !User::findIdentity(Yii::$app->user->id)->postAlreadyLiked($post->id)) ? "hidden" : "";?>">
                <span class="button-like glyphicon glyphicon-heart-empty"></span>
                </a>
            <span class="likes"><?= $post->likes_counter ?></span>
        </div>
    </div>

    <div class="col-md-6">


    <div class="well">
        &nbsp;&nbsp;By <?= Html::a(Html::encode($post->user->username), ['users/view', 'id' => $post->user_id]) ?>, <?= Yii::$app->formatter->format($post->created_at, 'relativeTime'); ?>
        <?php if ($post->user->avatar): ?>
            <?= Html::img($post->user->getThumbFileUrl('avatar', 'thumb'), ['class' => 'img-circle img-card']) ?>
        <?php endif; ?><br>
        &nbsp;&nbsp;<?= Html::encode($post->user->description) ?>
        </div>
    </div>

</div>
<div class="clearfix"></div><br>
<span class="pill-tag"><?= implode(' ', $tagLinks) ?></span>

<?= BlogCommentsWidget::widget(['post' => $post]) ?>

<h3 class="text-center">By the way:</h3><hr>
<div class="row bg-1">
    <?= LastPostsWidget::widget([
        'limit' => 9,
    ]) ?>
</div><hr>


<?php $this->registerJs("
    $(document).ready(function () {
    
    $('a.button-like').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };        
        
        $.post('/profile/like/add', params, function(data) {

            if (data.success) {
            $('a.button-like').addClass('hidden');
            $('a.button-unlike').removeClass('hidden');
            $('.likes').html(data.likes);
            }      
        });
        return false;
    });

    $('a.button-unlike').click(function () {

        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };        
        
        $.post('/profile/like/delete', params, function(data) {
        
            if (data.success) {
            $('a.button-unlike').addClass('hidden');
            $('a.button-like').removeClass('hidden');
            $('.likes').html(data.likes);
            }
        });
        return false;
    });
});

"); ?>

