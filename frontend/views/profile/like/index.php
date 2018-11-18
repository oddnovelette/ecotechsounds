<?php

/* @var $this yii\web\View */

use src\models\Blog\Post;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Your likes collection';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h2>All posts you`ve liked</h2><hr>

    <?= GridView::widget([
        'showHeader'=> false,
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'value' => function (Post $model) {
                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'title',
                'label' => false,
                'value' => function (Post $model) {
                    return Html::a(Html::encode($model->title), ['/blog/post/post', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
            ],
        ],
    ]); ?>
</div>
