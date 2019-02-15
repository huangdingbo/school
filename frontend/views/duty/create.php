<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Duty */
$type = (Yii::$app->request->get())['type'];
$this->title = '添加职务';
$this->params['breadcrumbs'][] = ['label' => ($type == '1' ? '学生职务表配置' : '教师职务表配置'), 'url' => ['index','type' => $type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="duty-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
