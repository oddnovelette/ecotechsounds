<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category application\models\Blog\Category */

use yii\helpers\Html;
$this->title = $category->getSeoTitle();
$this->registerMetaTag(['name' =>'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $category->meta->keywords]);
$this->params['breadcrumbs'][] = ['label' => 'Magazine', 'url' => ['index']];
$this->params['breadcrumbs'][] = $category->name;
$this->params['active_category'] = $category;
?>

<h1><?= Html::encode($category->getHeadingTile()) ?></h1>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
