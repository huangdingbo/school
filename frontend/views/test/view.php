<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Test */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="test-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'test_num',
            'test_name',
            [
                'attribute' => 'grade_num',
                'label' => '年级',
                'value'=>$model->grade0->name,
            ],
            [
                'attribute' => 'status',
                'label' => '状态',
                'value'=>function($model){
                    return $model->status == 1 ? '正在进行' : '已结束';
                }
            ],
            [
                'attribute' => 'type',
                'label' => '类型',
                'value'=>function($model){
                    return $model->type == 1 ? '理科' : '文科';
                }
            ],
            [
                'attribute' => 'benkeWire',
                'label' => '本科线',
                'value'=> !isset($model->wire0->benke_wire)  ? '未划线' : $model->wire0->benke_wire,
            ],
            [
                'attribute' => 'benkeNum',
                'label' => '本科上线人数',
                'value'=> !isset($model->wire0->benke_wire) ? '未划线' :$model->wire0->benke_num,
            ],
            [
                'attribute' => 'zhongbenWire',
                'label' => '重本线',
                'value'=>!isset( $model->wire0->zhongben_wire) ? '未划线' : $model->wire0->zhongben_wire,
            ],
            [
                'attribute' => 'zhongbenNum',
                'label' => '重本上线人数',
                'value'=>!isset( $model->wire0->zhongben_wire) ? '未划线' : $model->wire0->zhongben_num,
            ],
            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>