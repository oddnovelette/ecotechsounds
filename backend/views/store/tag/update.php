<?php
/* @var $this yii\web\View */
/* @var $tag application\models\Store\Tag */
/* @var $model application\forms\Store\TagForm */

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
