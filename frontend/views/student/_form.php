<?php

use frontend\models\Grade;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model,'sex')
        ->dropDownList([1=>'男',2=>'女'],['prompt'=>'请选择学生性别']);
    ?>

    <?= $form->field($model, 'born_time')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
//            'startDate' =>date('Y-m-d'), //设置今天之前的日期不能选择
        ]
    ]); ?>
    <?php $gradeList = Grade::find()
        ->select('the,the')
        ->indexBy('the')
        ->orderBy('the ASC')
        ->column();
    ;?>
    <?=$form->field($model,'grade')
        ->dropDownList($gradeList,['prompt'=>'请选择届'])->label('年级（届）');
    ?>

    <?=$form->field($model,'banji')
        ->dropDownList(\frontend\models\Class0::find()
            ->select('name,id')
            ->indexBy('id')
            ->column(),['prompt'=>'请选择班级']);
    ?>

    <?=$form->field($model,'duty')
        ->dropDownList(\frontend\models\Duty::find()
            ->select('name,id')
            ->where(['type'=>1])
            ->indexBy('id')
            ->column(),['prompt'=>'请选择学生职务']);
    ?>

    <?= $form->field($model, 'home_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'admission_time')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
//            'startDate' =>date('Y-m-d'), //设置今天之前的日期不能选择
        ]
    ]); ?>

    <?=$form->field($model,'political_landscape')
        ->dropDownList(\frontend\models\Political::find()
            ->select('name,id')
            ->where(['type'=>1])
            ->indexBy('id')
            ->column(),['prompt'=>'请选择学生政治面貌']);
    ?>

    <?=$form->field($model, 'pic')->widget('manks\FileInput', []); ?>

    <?=$form->field($model,'type')
        ->dropDownList([0=>'文科',1=>'理科'],['prompt'=>'请选择学生类型']);
    ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
