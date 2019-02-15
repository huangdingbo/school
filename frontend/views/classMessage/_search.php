<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClassMessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="class-message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'grade') ?>

    <?= $form->field($model, 'managers') ?>

    <?= $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'slogan') ?>

    <?php // echo $form->field($model, 'leadership') ?>

    <?php // echo $form->field($model, 'num') ?>

    <?php // echo $form->field($model, 'insert_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
