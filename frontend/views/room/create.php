<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Room */

$this->title = '创建考场';
$this->params['breadcrumbs'][] = ['label' => '考场设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-create">

    <?= $this->render('_form', [
        'model' => $model,
        'locationMap' => $locationMap,
        'data' => $data
    ]) ?>

</div>
