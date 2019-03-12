<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CaseProcess */

$this->title = 'Create Case Process';
$this->params['breadcrumbs'][] = ['label' => 'Case Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="case-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
