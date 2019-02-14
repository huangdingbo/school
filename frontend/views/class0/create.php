<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Duty */

$this->title = '添加班级';
$this->params['breadcrumbs'][] = ['label' => '班级表配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="duty-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
