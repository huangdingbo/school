<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Test */

$this->title = '发布考试';
$this->params['breadcrumbs'][] = ['label' => '考试信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>