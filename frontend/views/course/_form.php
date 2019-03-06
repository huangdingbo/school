<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->textInput() ?>

    <?= $form->field($model, 'banji')->textInput() ?>

    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'teacher_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'week_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'section_num')->textInput() ?>

    <?= $form->field($model, 'insert_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
