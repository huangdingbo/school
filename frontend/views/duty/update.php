<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Duty */

$this->title = '修改职务信息: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Duties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="duty-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
