<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
        $typeList = \common\models\config::$caseType;
    ;?>

    <?=$form->field($model,'type')
        ->dropDownList($typeList,['prompt'=>'请选择事件类型']);
    ?>

    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className(),[
        'clientOptions' => [
            'lang' => 'zh_cn',
            'plugins' => ['clips', 'fontcolor','imagemanager']
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('创建', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
