<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Kaohao */

$this->title = 'Create Kaohao';
$this->params['breadcrumbs'][] = ['label' => 'Kaohaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kaohao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
