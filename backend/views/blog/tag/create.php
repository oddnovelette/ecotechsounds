<?php

/* @var $this yii\web\View */
/* @var $model src\forms\Blog\TagForm */

$this->title = 'Create New Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tag-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
