<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CaseProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="case-process-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'case_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'process')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instructions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
