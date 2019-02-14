<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Duty */

$this->title = '添加学历';
$this->params['breadcrumbs'][] = ['label' => '教师学历表配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="duty-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
