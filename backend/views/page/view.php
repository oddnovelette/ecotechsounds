<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $page application\models\Page */

$this->title = $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $page->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $page->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-header with-border">Pages</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $page,
                'attributes' => [
                    'id',
                    'title',
                    'slug',
                    'sort',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Content</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($page->content) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Meta tags & SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $page,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]) ?>
        </div>
    </div>
</div>
