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
            <li class="nav-item"><a class="nav-link <?=$this->context->id == 'profile/default' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/default')) ?>"><span class="gl-profile glyphicon glyphicon-user"></span> Profile</a></li>
            <li class="nav-item"><a class="nav-link <?=$this->context->id == 'profile/like' ? 'active' : ''; ?>" href="<?= Html::encode(Url::to('/profile/like/index')) ?>"><i class="gl-profile fa fa-heart"></i> Likes</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="gl-profile fa fa-cogs"></i> Settings</a></li>
        </ul>
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent() ?>