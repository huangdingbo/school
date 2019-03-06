<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Student */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-view">

    <h1><?= Html::img($model->pic,['height'=>'120','width'=>'150']) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'student_id',
            'test_id',
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value'=>function($model){
                    return $model->sex == 1 ? '男' : '女';
                }
            ],
            'born_time',
            [
                'attribute' => 'grade',
                'label' => '年级',
                'value'=>$model->grade0->name,
            ],
            [
                'attribute' => 'banji',
                'label' => '班级',
                'value'=>$model->class0->name,
            ],
            [
                'attribute' => 'duty',
                'label' => '职务',
                'value'=>$model->duty0->name,
            ],
            'home_address',
            'admission_time',
            [
                'attribute' => 'political_landscape',
                'label' => '政治面貌',
                'value'=>$model->political0->name,
            ],
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
