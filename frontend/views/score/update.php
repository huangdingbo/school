<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Score */

$this->title = '修改学生成绩 ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="score-update">

    <h1><?= Html::img($model->img,['height'=>'120','width'=>'150']) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>