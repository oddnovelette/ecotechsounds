<?php

/* @var $this yii\web\View */
/* @var $model src\forms\Store\LabelForm */

$this->title = 'Create Label';
$this->params['breadcrumbs'][] = ['label' => 'Labels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="label-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
