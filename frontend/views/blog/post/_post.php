<?php

/* @var $this yii\web\View */
/* @var $model src\models\Blog\Post */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['post', 'slug' => $model->slug]);
?>
<?php \yii2masonry\yii2masonry::begin([
    'clientOptions' => [
        'itemSelector' => '.item'
    ]
]); ?>

<div class="item">
    <?php if ($model->photo): ?>
        <div>
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($model->getThumbFileUrl('photo', 'thumb')) ?>" alt="" class="img-responsive" />
            </a>
        </div>
    <?php endif; ?>
    <h3 class="post-title-list"><span><a href="<?= Html::encode($url) ?>"><?= Html::encode($model->title) ?></a></span></h3>
    <p class="post-date"><span>&nbsp;
        <span class="glyphicon glyphicon-eye-open"></span> <?= $model->views_counter ?>
            <span class="glyphicon glyphicon-comment"></span> <?= $model->comments_counter ?>
                <span class="glyphicon glyphicon-heart"></span> <?= $model->likes_counter ?></span>
    </p>
    <p class="post-text-preview"><?= Yii::$app->formatter->asNtext($model->description) ?></p>

    <div class="pill-author">
        <?php if ($model->getUserModel($model->user_id)->avatar): ?>
            <?= Html::img($model->getUserModel($model->user_id)->getThumbFileUrl('avatar', 'thumb'), ['class' => 'img-circle avatar-pill']) ?>
        <?php else: ?>
            <i class="fa fa-user-circle-o avatar-pill"></i>
        <?php endif; ?>

        &nbsp;&nbsp;By <?= Html::a(Html::encode($model->getUserModel($model->user_id)->username), ['users/view', 'id' => $model->user_id]) ?>
         | <?= Yii::$app->formatter->format($model->created_at, 'relativeTime'); ?>
    </div>

</div>

<?php \yii2masonry\yii2masonry::end(); ?>