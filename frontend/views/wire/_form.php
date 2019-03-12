<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Wire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wire-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'benke_wire')->textInput() ?>

    <?= $form->field($model, 'zhongben_wire')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
