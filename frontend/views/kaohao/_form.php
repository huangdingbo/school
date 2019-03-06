<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Kaohao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kaohao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'test_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cand_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exam_room')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seat_num')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'room_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'teachers')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
