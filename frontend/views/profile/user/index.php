<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model src\models\User */

$this->title = 'Profile';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['users/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h2><?= Html::encode($model->username) ?>`s profile info</h2><hr>

    <div class="panel-heading">
        <?php if ($model->avatar): ?>
            <?= Html::img($model->getThumbFileUrl('avatar', 'list'), ['class' => 'img-circle img-card avatar-prof']) ?>
        <?php else: ?>
            <i class="fa fa-user-circle-o img-card"></i>
        <?php endif; ?>
        <p>
            <a class="author"><?= Html::encode($model->username) ?></a><br>
            <span class="author">Signed up <?= Yii::$app->formatter->asDate($model->created_at) ?></span><br>
            <span class="author">Profile updated <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
        </p>
    </div>
    <div class="panel-body well">
        <?= Yii::$app->formatter->asNtext($model->description) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            [
                'label' => 'First name',
                'value' => $model->real_name,
            ],
            [
                'label' => 'Last name',
                'value' => $model->real_surname,
            ],
            [
                'label' => '<i class="fa fa-map-marker"></i> From',
                'value' => $model->user_from,
            ],
            [
                'label' => '<i class="fa fa-soundcloud"></i> Soundcloud',
                'value' => $model->soundcloud_link,
            ],
            [
                'label' => '<i class="fa fa-bandcamp"></i> Bandcamp',
                'value' => $model->bandcamp_link,
            ],
            [
                'label' => '<span class="glyphicon glyphicon-cd"></span> Discogs',
                'value' => $model->discogs_link,
            ],
        ],
    ]) ?>

</div>
