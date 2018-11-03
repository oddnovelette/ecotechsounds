<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model src\models\User */
?>

<div class="panel panel-default col-md-5 users">
    <div class="panel-heading">
        <?php if ($model->avatar): ?>
            <?= Html::img($model->getThumbFileUrl('avatar', 'thumb'), ['class' => 'img-circle img-card']) ?>
            <?php else: ?>
            <i class="fa fa-user-circle-o img-card"></i>
        <?php endif; ?>
        <p>
        <span class="author"><?= Html::a(Html::encode($model->username), ['view', 'id' => $model->id]) ?></span><br>
            <span class="reply">Signed up <?= Yii::$app->formatter->asDatetime($model->created_at) ?></span>
        </p>
    </div>
    <div class="panel-body">
        <?= Yii::$app->formatter->asNtext($model->description) ?>
    </div>
</div>
