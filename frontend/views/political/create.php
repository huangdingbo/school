<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Duty */
$type = (Yii::$app->request->get())['type'];
$this->title = '添加政治面貌';
$this->params['breadcrumbs'][] = ['label' => ($type == '1' ? '学生政治面貌表配置' : '教师政治面貌表配置'), 'url' => ['index','type' => $type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="duty-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
