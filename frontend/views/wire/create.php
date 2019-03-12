<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Wire */

//$this->title = 'Create Wire';
//$this->params['breadcrumbs'][] = ['label' => 'Wires', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wire-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
