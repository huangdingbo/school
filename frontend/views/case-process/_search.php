<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CaseProcessSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="case-process-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'case_num') ?>

    <?= $form->field($model, 'process') ?>

    <?= $form->field($model, 'instructions') ?>

    <?= $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'date_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
