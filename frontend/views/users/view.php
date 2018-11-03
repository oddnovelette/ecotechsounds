<?php

use frontend\widgets\LastUserPosts;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model src\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
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

    <h2>Recent Posts</h2><hr>

    <?= LastUserPosts::widget([
            'user' => $model,
    ]) ?>

</div>
