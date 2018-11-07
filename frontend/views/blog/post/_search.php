<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<h3>Ecotechsounds magazine</h3>
<div class="row searchrow">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-xs-2" style="padding-right: 0;">

        <?= $form->field($model, 'language')->dropDownList($model->languageList(), ['class' => 'form-control input-sm'])->label(false) ?>
    </div>

    <div class="col-xs-2 search">

        <?= $form->field($model, 'category_id')->dropDownList($model->categoriesList(), ['prompt' => 'All categories', 'class' => 'form-control input-sm'])->label(false) ?>

    </div>

    <div class="col-xs-3">
        <?= DatePicker::widget([
            'model' => $model,
            'options' => ['placeholder' => 'Dated from'],
            'options2' => ['placeholder' => 'To'],
            'addInputCss' => 'form-control input-sm datepick',
            'attribute' => 'date_from',
            'attribute2' => 'date_to',
            'type' => DatePicker::TYPE_RANGE,
            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=> true,
                'format' => 'yyyy-mm-dd',
            ],
        ]) ?>
    </div>

    <div class="col-xs-3 search">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'By title ..', 'class' => 'form-control input-sm'])->label(false) ?>
    </div>

    <span class="input-group-btn">
        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
        <?= Html::a('<i class="fa fa-times"></i>', [''], ['class' => 'btn btn-default btn-sm']) ?>
    </span>

</div>
<?php ActiveForm::end(); ?>



