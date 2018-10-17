<?php

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <div class="row">
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>
        <div class="clearfix"></div>
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.banners.index') }}">Posts</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.profile.home') }}">Settings</a></li>
        </ul>
    </div>
<?php $this->endContent() ?>