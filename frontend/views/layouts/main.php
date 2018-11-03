<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="<?= Html::encode(Url::canonical()) ?>" rel="canonical"/>
    <?php $this->head() ?>
</head>

<body id="myPage" data-offset="50">
<?php $this->beginBody() ?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div id="page-preloader"><span class="spinner"></span></div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Html::encode(Yii::$app->homeUrl) ?>"><?= Html::encode(Yii::$app->name) ?></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= Html::encode(Url::to('/magazine')) ?>">Magazine</a></li>
                <li><a href="<?= Html::encode(Url::to('/users/index')) ?>">Users</a></li>
                <li><a href="#band">Works</a></li>

               <?php if (Yii::$app->user->isGuest): ?>
                   <li><a href="<?= Html::encode(Url::to('/site/signup')) ?>">Join</a></li>
                   <li role="separator" class="divider"></li>
                   <li><a href="<?= Html::encode(Url::to('/site/login')) ?>">Login</a></li>
               <?php else: ?>



                <li class="dropdown">

                    <a class="dropdown-toggle nav-pic" data-toggle="dropdown" href="#">
                        <?php if (Yii::$app->user->identity->avatar): ?>
                            <?= Html::img(Yii::$app->user->identity->getThumbFileUrl('avatar', 'thumb'), ['class' => 'img-circle avatar-pill']) ?>
                        <?php endif; ?>

                        &nbsp;&nbsp;<?= Yii::$app->user->identity->username ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Html::encode(Url::to('/profile/user/view')) ?>"><span class="gl-profile glyphicon glyphicon-user"></span> <?= Yii::$app->user->identity->username ?>`s Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= Html::encode(Url::to('/profile/like/index')) ?>"><i class="gl-profile fa fa-heart"></i> Collection</a></li>
                        <li><a href="<?= Html::encode(Url::to('/profile/user/update')) ?>"><i class="gl-profile fa fa-cogs"></i> Profile Settings</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= Html::encode(Url::to('/site/logout')) ?>"><i class="gl-profile fa fa-power-off"></i> Sign out</a></li>
                    </ul>
                </li>

               <? endif; ?>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-option-vertical fa-lg"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Html::encode(Url::to('/site/contact')) ?>">Contact us</a></li>
                        <li><a href="<?= Html::encode(Url::to('/site/about')) ?>">About</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<?php if (Url::current() !== Yii::$app->homeUrl): ?>
<div class="container">
    <?php endif; ?>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'homeLink' => false]) ?>
    <?= \lavrentiev\widgets\toastr\NotificationFlash::widget() ?>
    <?= $content ?>

</div>

<!-- Footer -->
    <footer>

        <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a><br><br>
        <p>Copyright &copy; <?= date('Y') ?>
            <a href="<?= Html::encode(Yii::$app->homeUrl) ?>" title="<?=  Html::encode(Yii::$app->name) ?>">.
                    <?=  Html::encode(Yii::$app->name) ?>
            </a>
        </p>

    </footer>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>
