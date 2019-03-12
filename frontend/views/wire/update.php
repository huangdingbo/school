<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Wire */

$this->title = 'Update Wire: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wire-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
