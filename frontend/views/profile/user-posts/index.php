<?php

use src\helpers\PostHelper;
use src\models\Blog\Post;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-posts">
    <h2>Your posts</h2>
    <?= Html::a('<i class="fa fa-plus"></i> Create New Post', ['create'], ['class' => 'btn btn-primary']) ?>

    <?= GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'value' => function (Post $model) {
                    return $model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : null;
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            [
                'attribute' => 'created_at',
                'label'=> 'Added',
                'format' => 'relativeTime',
            ],
            [
                'attribute' => 'title',
                'value' => function (Post $model) {
                    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                },
                'filterInputOptions' => ['placeholder' => 'Search by post title..', 'class' => 'form-control', 'id' => null],
                'format' => 'raw',
            ],
            [
                'label' => 'Category',
                'attribute' => 'category_id',
                'filterInputOptions' => ['prompt' => 'All categs', 'class' => 'form-control', 'id' => null],
                'filter' => $searchModel->categoriesList(),
                'value' => 'category.name',
            ],
            [
                'attribute' => 'status',
                'filterInputOptions' => ['prompt' => 'All Statuses', 'class' => 'form-control', 'id' => null],
                'filter' => $searchModel->statusList(),
                'value' => function (Post $model) {
                    return PostHelper::statusLabel($model->status);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'language',
                'filterInputOptions' => ['prompt' => 'All langs', 'class' => 'form-control', 'id' => null],
                'filter' => $searchModel->languageList(),
                'value' => function (Post $model) {
                    return PostHelper::languageLabel($model->language);
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>
</div>
