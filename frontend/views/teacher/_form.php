<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model frontend\models\Teacher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->textInput(['maxlength' => true]) ?>

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

    <?=$form->field($model,'duty')
        ->dropDownList(\frontend\models\Duty::find()
            ->select('name,id')
            ->where(['type'=>2])
            ->indexBy('id')
            ->column(),['prompt'=>'请选择教师职务']);
    ?>

        <?=$form->field($model,'diploma')
            ->dropDownList(\frontend\models\Diploma::find()
                ->select('name,id')
                ->indexBy('id')
                ->column(),['prompt'=>'请选择教师学历']);
        ?>

    <?=$form->field($model,'political_landscape')
        ->dropDownList(\frontend\models\Political::find()
            ->select('name,id')
            ->where(['type'=>2])
            ->indexBy('id')
            ->column(),['prompt'=>'请选择教师政治面貌']);
    ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model,'title')
        ->dropDownList(\frontend\models\Title::find()
            ->select('name,id')
            ->indexBy('id')
            ->column(),['prompt'=>'请选择教师职称']);
    ?>

    <?=$form->field($model,'group')
        ->dropDownList(Yii::$app->params['groupConfig'],['prompt'=>'请选择教师所在分组']);
    ?>

    <?=$form->field($model, 'pic')->widget('manks\FileInput', []); ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
