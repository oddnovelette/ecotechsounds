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
<div class="profile-index"><br><br>
    <?= GridView::widget([
        'showHeader'=> false,
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'value' => function (Post $model) {
                    return $model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : null;
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
