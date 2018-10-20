<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\widgets\Blog\BlogCategoriesWidget;
?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <aside class="col-sm-12 text-right cat hidden-xs">
        <?= BlogCategoriesWidget::widget([
            'active' => $this->params['active_category'] ?? null
        ]) ?>
    </aside>
    <div class="row">
        <div id="content" class="col-sm-12">
            <?= $content ?>
        </div>

    </div>

<?php $this->endContent() ?>
