<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Class0 */

$this->title = $model->grade0->name.'('.$model->name.')';
$this->params['breadcrumbs'][] = ['label' => 'Class0s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="class0-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'label' => '班级',
                'value'=>$model->class0->name,
            ],
            [
                'attribute' => 'grade',
                'label' => '年级',
                'value'=>$model->grade0->name,
            ],
            [
                'attribute' => 'managers',
                'label' => '班主任',
                'value'=>$model->manager0->name,
            ],
            [
                'attribute' => 'leadership',
                'label' => '分管领导',
                'value'=>$model->manager0->name,
            ],
            [
                'attribute' => 'num',
                'label' => '人数',
                'value'=>function($model){
                    $numModel = \frontend\models\Student::find()
                        ->where(['banji'=>$model->id,'grade'=>$model->grade])
                        ->count();
                    return $numModel.'人';
                },
            ],
            [
                'attribute' => 'alias',
                'label' => '别名',
                'value'=>function($model){
                    if ($model->alias == 1){
                        return '火箭班';
                    }elseif ($model->alias == 2){
                        return '飞机班';
                    }
                    return '普通班';
                },
            ],
            'slogan',


            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>
