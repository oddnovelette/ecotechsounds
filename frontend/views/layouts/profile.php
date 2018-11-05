<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $content string */
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <div class="row">
        <div class="clearfix"></div>
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link <?=Yii::$app->controller->action->id == 'view' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/user/view')) ?>"><span class="gl-profile glyphicon glyphicon-user"></span> Profile</a></li>
            <li class="nav-item"><a class="nav-link <?=Yii::$app->controller->action->id == 'posts' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/user-posts/posts')) ?>"><span class="gl-profile fa fa-file"></span> Posts</a></li>
            <li class="nav-item"><a class="nav-link <?=Yii::$app->controller->action->id == 'index' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/like/index')) ?>"><i class="gl-profile fa fa-heart"></i> Likes</a></li>
            <li class="nav-item"><a class="nav-link <?=Yii::$app->controller->action->id == 'update' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/user/update')) ?>"><i class="gl-profile fa fa-cogs"></i> Settings</a></li>
            <li class="nav-item"><a class="nav-link <?=Yii::$app->controller->action->id == 'update' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/user/update')) ?>"><i class="gl-profile fa fa-sliders"></i> Account</a></li>
        </ul>
        <div id="content" class="col-sm-12">
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent() ?>