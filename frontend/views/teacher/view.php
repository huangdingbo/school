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
            'teacher_id',
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value'=>function($model){
                    return $model->sex == 1 ? '男' : '女';
                }
            ],
            'born_time',
            [
                'attribute' => 'duty',
                'label' => '职务',
                'value'=>$model->duty0->name,
            ],
            [
                'attribute' => 'diploma',
                'label' => '学历',
                'value'=>$model->diploma0->name,
            ],
            [
                'attribute' => 'political_landscape',
                'label' => '政治面貌',
                'value'=>$model->political0->name,
            ],
            [
                'attribute' => 'title',
                'label' => '职称',
                'value'=>$model->title0->name,
            ],
            [
                'attribute' => 'group',
                'label' => '所在分组',
                'value'=>function($model){
                    return Yii::$app->params['groupConfig'][$model->group];
                },
            ],
            'tel',
            'qq',
            'email:email',
            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>
