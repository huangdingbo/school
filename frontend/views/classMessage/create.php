<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Class0 */

$this->title = '添加班级信息';
$this->params['breadcrumbs'][] = ['label' => '班级档案管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class0-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
