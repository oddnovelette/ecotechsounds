<?php

/* @var $this yii\web\View */
/* @var $post application\models\Blog\Post */
/* @var $model application\forms\Blog\PostForm */

$this->title = 'Update Post: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="post-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
