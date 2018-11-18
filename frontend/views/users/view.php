<?php

use frontend\widgets\LastUserPosts;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model src\models\User */

$this->title = $model->username;
?>

<div class="user-view">
    <div class="wrap-prof">

        <?php if ($model->avatar): ?>
                <div class="user-wrap col-xs-12" style="background: url(<?= $model->getThumbFileUrl('avatar', 'list') ?>) center no-repeat; background-size:cover; filter: blur(60px);">
              <?php else: ?>
                <div class="user-wrap col-xs-12">
            <?php endif; ?>
                </div>
            </div>

            <div class="col-sm-6 inside-profile">

                <?php if ($model->avatar): ?>
                    <?= Html::img($model->getThumbFileUrl('avatar', 'main'), ['class' => 'img inside-profile img-card avatar-prof']) ?>
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?rounded=true&size=200&name=<?=$model->username?>+<?=$model->real_surname?>"
                         class="fa fa-user-circle-o inside-profile img-card" />

                    <div class="clearer"> </div>

                <?php endif; ?>
            </div>

            <div class="col-md-6 col-md-push-2 col-sm-12 prof-info-user">

                <span class="username">
                    <?= StringHelper::truncateWords(Html::encode($model->real_name), 25) ?>
                    <?= StringHelper::truncateWords(Html::encode($model->real_surname), 25) ?>
                </span><br>

                <span>@<?= StringHelper::truncateWords(Html::encode($model->username), 40) ?></span><br>

                <?php if (!empty($model->user_from)): ?>
                <span><i class="fa fa-map-marker fa-lg"></i> <?= StringHelper::truncateWords(Html::encode($model->user_from), 50) ?></span><br>
                <? endif; ?>

                <span>Signed: <?= Yii::$app->formatter->asDate($model->created_at) ?></span><br>
                <span>Online: <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span><br>

                <?php if (!empty($model->soundcloud_link)): ?>
                    <span class="user-link">
                <?= Html::a('<i class="fa fa-soundcloud fa-lg"></i> Soundcloud', Url::to([$model->soundcloud_link], 'https')) ?>
                    </span>
                <? endif; ?>

                <?php if (!empty($model->bandcamp_link)): ?>
                    <span class="user-link">
                <?= Html::a('<i class="fa fa-bandcamp fa-lg"></i> Bandcamp', Url::to([$model->bandcamp_link], 'https')) ?>
                    </span>
                <? endif; ?>

                <?php if (!empty($model->discogs_link)): ?>
                    <span class="user-link">
                <?= Html::a('<span class="glyphicon glyphicon-cd"></span> Discogs', Url::to([$model->discogs_link], 'https')) ?>
                    </span><br>
                <? endif; ?>

            </div>
    </div>

    <div class="clearfix"></div>

    <div class="clearer"> </div>

    <div class="panel panel-default">
        <div class="panel-heading"><h1><?= Html::encode($model->username) ?></h1></div>
        <?php if (!empty($model->description)): ?>
        <div class="panel-body"><?= Html::encode($model->description) ?></div>
        <?php endif; ?>
    </div>

    <h2>Recent Posts</h2>
    <span id="text-under">Last posts from all threads</span>
    <hr>

    <?= LastUserPosts::widget([
            'user' => $model,
    ]) ?>
