<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Teacher */

$this->title = '添加教师信息';
$this->params['breadcrumbs'][] = ['label' => '教师档案管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
