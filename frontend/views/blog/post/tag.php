<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $tag src\models\Blog\Tag */

use yii\helpers\Html;

$this->title = 'Posts with tag ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Magazine', 'url' => ['index']];
$this->params['breadcrumbs'][] = $tag->name;
?>

    <h4>#<?= Html::encode($tag->name) ?></h4>
<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
