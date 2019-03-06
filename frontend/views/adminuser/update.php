<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '修改管理员资料：'.$model->nickname;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改管理员资料';
?>
<div class="adminuser-update">

    <?= $this->render('_updateForm', [
        'model' => $model,
    ]) ?>

</div>
