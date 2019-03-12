<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cases */

$this->title = '激活';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $userList = \frontend\models\Adminuser::find()->select('nickname,id')
        ->indexBy('id')
        ->column();
    ;?>

    <?= $form->field($model, 'instr')->textarea(['rows' => 6]) ?>

    <?=$form->field($model, 'instrPic')->widget('manks\FileInput', []); ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>