<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Score */

$this->title = $model->test_name.'-'.$model->name.'-'.'考试成绩';
$this->params['breadcrumbs'][] = ['label' => '学生成绩查询', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="score-view">

    <h1><?= Html::img($model->img,['height'=>'120','width'=>'150']) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'test_name',
            'cand_id',
            'student_id',
            'name',
            'grade',
            'banji',
            'test_room',
            'location',
            'seat_num',
            'chinese',
            'math',
            'english',
            [
                'attribute' => $model->type == 1 ? $model->physics : $model->politics,
                'label' => $model->type == 1 ? '物理' : '政治',
                'value'=> $model->type == 1 ? $model->physics : $model->politics,
            ],
            [
                'attribute' => $model->type == 1 ? $model->chemistry : $model->history,
                'label' => $model->type == 1 ? '化学' : '历史',
                'value'=> $model->type == 1 ? $model->chemistry : $model->history,
            ],
            [
                'attribute' => $model->type == 1 ? $model->biology : $model->geography,
                'label' => $model->type == 1 ? '生物' : '地理',
                'value'=> $model->type == 1 ? $model->biology : $model->geography,
            ],
            'total',
            'class_rank',
            'school_rank',
            [
                'attribute' => 'type',
                'label' => '类型',
                'value'=>function($model){
                    return $model->type == 1 ? '理科' : '文科';
                }
            ],
            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>