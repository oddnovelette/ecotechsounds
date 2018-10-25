<?php

/* @var $this yii\web\View */
/* @var $label src\models\Store\Label */
/* @var $model src\forms\Store\LabelForm */

$this->title = 'Update Label: ' . $label->name;
$this->params['breadcrumbs'][] = ['label' => 'Labels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $label->name, 'url' => ['view', 'id' => $label->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="label-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
