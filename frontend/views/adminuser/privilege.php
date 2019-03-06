<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
$AdminModel = \frontend\models\Adminuser::findOne($id);
$this->title = '权限设置：'.$AdminModel->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="adminuser-update">

    <p>

    </p>
    <div class="adminuser-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?=Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegeArray) ?>
        <p>

        </p>
        <div class="form-group">
            <?= Html::submitButton('设置',['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>


</div>
