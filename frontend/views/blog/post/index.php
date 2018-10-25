<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category src\models\Blog\Category */

use yii\helpers\Html;

$this->title = 'Magazine';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
