<?php

/* @var $this yii\web\View */
/* @var $model application\forms\Blog\CategoryForm */

$this->title = 'Create Page';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
