<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Teacher */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="teacher-view">

    <h1><?= Html::img($model->pic,['height'=>'120','width'=>'150']) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'sex',
            'teacher_id',
            'born_time',
            'grade',
            'banji',
            'duty',
            'diploma',
            'political_landscape',
            'tel',
            'qq',
            'email:email',
            'pic',
            'title',
            'grade_calss',
            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>
