<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Class0 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="class0-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model,'name')
        ->dropDownList(\frontend\models\Class0::find()
            ->select('name,id')
            ->indexBy('id')
            ->column(),['prompt'=>'请选择班级']);
    ?>

    <?=$form->field($model,'grade')
        ->dropDownList(\frontend\models\Grade::find()
            ->select('the,the')
            ->indexBy('the')
            ->orderBy('the ASC')
            ->column(),['prompt'=>'请选择年级']);
    ?>

    <?=$form->field($model,'managers')
        ->dropDownList(\frontend\models\Teacher::find()
            ->select('name,teacher_id')
            ->indexBy('teacher_id')
            ->orderBy('teacher_id ASC')
            ->column(),['prompt'=>'请选择班主任']);
    ?>

    <?=$form->field($model,'leadership')
        ->dropDownList(\frontend\models\Teacher::find()
            ->select('name,teacher_id')
            ->indexBy('teacher_id')
            ->orderBy('teacher_id ASC')
            ->column(),['prompt'=>'请选择分管领导']);
    ?>

    <?=$form->field($model,'alias')
        ->dropDownList([
            '1' => '火箭班',
            '2' => '飞机班',
            '3' => '普通班',
        ],['prompt'=>'请选择班级别名']);
    ?>

    <?= $form->field($model, 'slogan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
