<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\KaohaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kaohao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'test_num') ?>

    <?= $form->field($model, 'test_name') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'cand_num') ?>

    <?php // echo $form->field($model, 'student_name') ?>

    <?php // echo $form->field($model, 'class_name') ?>

    <?php // echo $form->field($model, 'grade_name') ?>

    <?php // echo $form->field($model, 'exam_room') ?>

    <?php // echo $form->field($model, 'seat_num') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'room_name') ?>

    <?php // echo $form->field($model, 'teachers') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
