<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Grade */

$this->title = '添加年级';
$this->params['breadcrumbs'][] = ['label' => '年级表配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
