<?php

/* @var $this yii\web\View */
/* @var $model application\models\User */
$this->title = 'Create New Member';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
