<?php

use frontend\models\Grade;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'test_name')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model,'grade_num')
        ->dropDownList(\frontend\models\Grade::find()
            ->select('the,id')
            ->indexBy('id')
            ->orderBy('the ASC')
            ->column(),['prompt'=>'请选择届'])->label('年级（届）');
    ?>

    <?=$form->field($model,'type')
        ->dropDownList([0=>'文科',1=>'理科'],['prompt'=>'请选择学生类型']);
    ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>