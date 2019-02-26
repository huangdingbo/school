<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GradeClass */

$this->title = '创建基础课程信息';
$this->params['breadcrumbs'][] = ['label' => '课程管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-class-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
