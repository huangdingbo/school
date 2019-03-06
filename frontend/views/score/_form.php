<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Score */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="score-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cand_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'student_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'test_name')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'banji')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'test_room')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'type')->textInput(['disabled'=>true,'value'=> $model->type == 1 ? '理科' : '文科']) ?>

    <?= $form->field($model, 'chinese')->textInput() ?>

    <?= $form->field($model, 'math')->textInput() ?>

    <?= $form->field($model, 'english')->textInput() ?>

    <?php
        if ($model->type == 1){
            echo $form->field($model, 'physics')->textInput();
            echo $form->field($model, 'chemistry')->textInput();
            echo $form->field($model, 'biology')->textInput();
        }else{
            echo $form->field($model, 'politics')->textInput();
            echo $form->field($model, 'history')->textInput();
            echo $form->field($model, 'geography')->textInput();
        }
    ?>



    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>