<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Room */


$this->params['breadcrumbs'][] = ['label' => 'Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="room-update">

    <?= $this->render('_form', [
        'model' => $model,
        'locationMap' => $locationMap,
        'data' => $data
    ]) ?>

</div>
