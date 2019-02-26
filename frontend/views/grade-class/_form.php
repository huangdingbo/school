<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\GradeClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grade-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model,'grade')
        ->dropDownList(\frontend\models\Grade::find()
            ->select('the,id')
            ->indexBy('id')
            ->orderBy('the ASC')
            ->column(),['prompt'=>'请选择届'])->label('年级（届）');
    ?>

    <?=$form->field($model,'banji')
        ->dropDownList(\frontend\models\Class0::find()
            ->select('name,id')
            ->indexBy('id')
            ->column(),['prompt'=>'请选择班级']);
    ?>


    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
