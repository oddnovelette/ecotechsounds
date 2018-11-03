<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;

/* @var $dataProvider yii\data\DataProviderInterface */

?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "<div class=\"js-masonry\">{items}</div>\n{pager}",
    'itemView' => '_post',
    'itemOptions' => [
        'class' => 'col-lg-4 col-md-6 col-xs-12',
    ],

]) ?>
