<?php

/* @var $this yii\web\View */
/* @var $post src\models\Blog\Post */
/* @var $model src\forms\Blog\PostForm */

$this->title = 'Update Post: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['posts']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="post-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
