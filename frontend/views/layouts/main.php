<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use frontend\widgets\Blog\LastPostsWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
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
                <li><a href="<?= Html::encode(Yii::$app->homeUrl) ?>">Home</a></li>
                <li><a href="<?= Html::encode(Url::to('/blog/post/index')) ?>">Magazine</a></li>
                <li><a href="#band">Residents</a></li>
                <li><a href="#band">Works</a></li>
                <li><a href="#tour">Store</a></li>

               <?php if (Yii::$app->user->isGuest): ?>
                   <li><a href="<?= Html::encode(Url::to('/site/signup')) ?>">Join</a></li>
                   <li><a href="<?= Html::encode(Url::to('/site/login')) ?>">Login</a></li>
               <?php else: ?>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= Yii::$app->user->identity->username ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Html::encode(Url::to('/profile/default')) ?>">Profile</a></li>
                        <li><a href="<?= Html::encode(Url::to('/site/logout')) ?>">Sign out</a></li>
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

    <?= Alert::widget() ?>

    <?= $content ?>
</div>

<!-- Footer -->
    <footer>

        <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a><br><br>
        <p>Copyright &copy;
            <a href="<?= Html::encode(Yii::$app->homeUrl) ?>" data-toggle="tooltip" title="<?=  Html::encode(Yii::$app->name) ?>">
                <?= date('Y') ?>.
                    <?=  Html::encode(Yii::$app->name) ?>
            </a>
        </p>

    </footer>

<?php $this->endBody() ?>
<script>
    $(document).ready(function(){
        // Initialize Tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Add smooth scrolling to all links in navbar + footer link
        $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {

                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function(){

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    })
</script>

</body>
</html>

<?php $this->endPage() ?>
