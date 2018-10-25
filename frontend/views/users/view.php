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

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= Yii::$app->formatter->asNtext($model->description) ?>
        </div>
    </div>

    <p class="pull-right">
        <?= Html::a('Create Post', ['user-posts/create', 'user_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <h2>My Recent Posts</h2>

    <?= LastUserPosts::widget([
            'user' => $model,
    ]) ?>

</div>
