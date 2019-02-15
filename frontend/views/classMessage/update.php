<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Class0 */

$this->params['breadcrumbs'][] = ['label' => 'Class0s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="class0-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
