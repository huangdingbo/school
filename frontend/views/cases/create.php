<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cases */

$this->title = '创建事件';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cases-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
