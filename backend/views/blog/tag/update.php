<?php

/* @var $this yii\web\View */
/* @var $tag src\models\Blog\Tag */
/* @var $model src\forms\Blog\TagForm */

$this->title = 'Update Tag: ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="tag-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
