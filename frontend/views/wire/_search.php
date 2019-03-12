<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\WireSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wire-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'test_num') ?>

    <?= $form->field($model, 'benke_wire') ?>

    <?= $form->field($model, 'zhongben_wire') ?>

    <?= $form->field($model, 'benke_num') ?>

    <?php // echo $form->field($model, 'zhongben_num') ?>

    <?php // echo $form->field($model, 'insert_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
