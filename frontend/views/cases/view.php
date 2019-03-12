<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cases */

//$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => 'Cases', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cases-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'case_num',
            'title',
            [
                'attribute' => 'type',
                'label' => '类型',
                'value'=>function($model){
                    return \common\models\config::$caseType[$model->type];
                }
            ],
            'description:html',
//            [
//                'attribute' => 'pic',
//                'format' => 'raw',
//                'value'=>function($model){
//                    return \yii\bootstrap\Html::img($model->pic,['width' => '120px','height' => '100px    ']);
//                }
//            ],
            [
                'attribute' => 'create_id',
                'label' => '创建人',
                'value' => function($model){
                    return (\frontend\models\Adminuser::findOne(['id' => $model->create_id]))->nickname;
                },
            ],
            [
                'attribute' => 'status',
                'label' => '当前状态',
                'value' => function($model){
                    return \common\models\config::$caseStatus[$model->status];
                },
            ],
            [
                'attribute' => 'process',
                'label' => '事件的一生',
                'format' => 'html',
                'value' => function($model){
                    $list = \frontend\models\CaseProcess::find()->where(['case_num' => $model->case_num])->orderBy('id asc')->all();
                    $str = '';
                    foreach ($list as $key => $item){
                        $str .= $item->date_time . ' -> ' .$item->process . "<br>";
                        $str .= "<b>图片：</b>".\yii\bootstrap\Html::img($item->pic,['width' => '120px','height' => '100px    '])."<br>";
                        $str .= "<b>说明：</b>".$item->instructions;
                        $str .= "<hr>";
                    }
                    return $str;
                },
            ],
        ],
    ]) ?>

</div>
