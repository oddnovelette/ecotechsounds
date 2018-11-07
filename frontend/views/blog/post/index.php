<?php

/* @var $this yii\web\View */

use frontend\widgets\Blog\BlogCategoriesWidget;

/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category src\models\Blog\Category */
/* @var $searchModel frontend\models\PostSearch */

$this->title = 'Magazine';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <aside class="col-sm-12 text-right cat hidden-xs">
        <?= BlogCategoriesWidget::widget([
            'active' => $this->params['active_category'] ?? null
        ]) ?>
    </aside>
    <div class="clearfix"></div>

    <?= $this->render('_list', [
        'dataProvider' => $dataProvider
    ]) ?>
