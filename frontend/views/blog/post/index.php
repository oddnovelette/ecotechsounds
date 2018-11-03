<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category src\models\Blog\Category */

$this->title = 'Magazine';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
