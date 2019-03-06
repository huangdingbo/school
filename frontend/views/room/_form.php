<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\models\Room */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model,'location')
        ->dropDownList($locationMap,['prompt'=>'请选择考场位置']);
    ?>

    <?=$form->field($model,'grade')
        ->dropDownList( \frontend\models\Grade::find()
            ->select('the,id')
            ->indexBy('id')
            ->orderBy('the ASC')
            ->column(),['prompt'=>'请选择届'])->label('年级（届）');
    ?>

    <?= $form->field($model, 'num')->textInput() ?>


    <?= $form->field($model, 'teachers')->widget(kartik\select2\Select2::classname(), [
    'data' => $data,
    'options' => ['multiple' => true,'placeholder' => '请选择 ...'],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
