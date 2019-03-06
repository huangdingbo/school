<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\KaohaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '考号管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kaohao-index">

    <p>
        <?= Html::a('导出考号信息', ['index',
            "KaohaoSearch[test_num]"=>isset($searchCondition["KaohaoSearch"]["test_num"]) ? $searchCondition["KaohaoSearch"]["test_num"] : '',
            "KaohaoSearch[test_name]"=>isset($searchCondition["KaohaoSearch"]["test_name"]) ? $searchCondition["KaohaoSearch"]["test_name"] : '',
            "KaohaoSearch[student_id]"=>isset($searchCondition["KaohaoSearch"]["student_id"]) ? $searchCondition["KaohaoSearch"]["student_id"] : '',
            "KaohaoSearch[cand_num]"=>isset($searchCondition["KaohaoSearch"]["cand_num"]) ? $searchCondition["KaohaoSearch"]["cand_num"] : '',
            "KaohaoSearch[student_name]"=>isset($searchCondition["KaohaoSearch"]["student_name"]) ? $searchCondition["KaohaoSearch"]["student_name"] : '',
            "KaohaoSearch[class_name]"=>isset($searchCondition["KaohaoSearch"]["class_name"]) ? $searchCondition["KaohaoSearch"]["class_name"] : '',
            "KaohaoSearch[grade_name]"=>isset($searchCondition["KaohaoSearch"]["grade_name"]) ? $searchCondition["KaohaoSearch"]["grade_name"] : '',
            "KaohaoSearch[exam_room]"=>isset($searchCondition["KaohaoSearch"]["exam_room"]) ? $searchCondition["KaohaoSearch"]["exam_room"] : '',
            "KaohaoSearch[seat_num]"=>isset($searchCondition["KaohaoSearch"]["seat_num"]) ? $searchCondition["KaohaoSearch"]["seat_num"] : '',
            "KaohaoSearch[type]"=>isset($searchCondition["KaohaoSearch"]["type"]) ? $searchCondition["KaohaoSearch"]["type"] : '',
            "KaohaoSearch[room_name]"=>isset($searchCondition["KaohaoSearch"]["room_name"]) ? $searchCondition["KaohaoSearch"]["room_name"] : '',
            "KaohaoSearch[teachers]"=>isset($searchCondition["KaohaoSearch"]["teachers"]) ? $searchCondition["KaohaoSearch"]["teachers"] : '',
            "KaohaoSearch[isExport]"=>'1',
        ], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'尾页',
        ],
        'columns' => [
            [
                'attribute' => 'test_num',
                'value' => 'test_num',
                'headerOptions' => ['width' => '150'],
            ],
            [
                'attribute' => 'student_id',
                'value' => 'student_id',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'cand_num',
                'value' => 'cand_num',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'test_name',
                'label' => '考试名',
                'value' => 'test_name',
                'filter' => \frontend\models\Test::find()
                    ->select('test_name,test_name')
                    ->indexBy('test_name')
                    ->orderBy('update_time desc')
                    ->column(),
                'headerOptions' => ['width' => '200'],
            ],
            [
                'attribute' => 'student_name',
                'value' => 'student_name',
                'headerOptions' => ['width' => '90'],
            ],
            [
                'attribute' => 'class_name',
                'label' => '班级',
                'value' => 'class_name',
                'filter' => \frontend\models\Class0::find()
                    ->select('name,name')
                    ->indexBy('name')
                    ->orderBy('id asc')
                    ->column(),
            ],
            [
                'attribute' => 'grade_name',
                'label' => '年级',
                'value' => 'grade_name',
                'filter' => \frontend\models\Grade::find()
                    ->select('the,the')
                    ->indexBy('the')
                    ->orderBy('id asc')
                    ->column(),
            ],
            [
                'attribute' => 'exam_room',
                'label' => '考场',
                'value' => 'exam_room',
                'filter' => common\models\config::getLocationMap(),
            ],

            [
                'attribute' => 'room_name',
                'label' => '考场名',
                'value' => 'room_name',
                'filter' => \frontend\models\Room::find()
                    ->select('name,name')

                    ->indexBy('name')
                    ->orderBy('id asc')
                    ->column(),
                'headerOptions' => ['width' => '105'],
            ],
            [
                'attribute' => 'teachers',
                'label' => '监考老师',
                'value' => function($dataProvider){
                    $list = json_decode($dataProvider->teachers);
                    if (is_array($list)){
                        $count = count($list);
                        $str = '';
                        for ($i=0;$i<$count;$i++){
                            if ($i == ($count-1)){
                                $str .= $list[$i];
                            }else{
                                $str .= $list[$i].',';
                            }
                        }
                        return $str;
                    }
                    return "未设置";

                },
                'headerOptions' => ['width' => '105'],
            ],
            [
                'attribute' => 'seat_num',
                'value' => 'seat_num',
                'headerOptions' => ['width' => '90'],
            ],
            [
                'attribute' => 'type',
                'label' => '类型',
                'value' => function($dataProvider){
                    return $dataProvider->type == 1 ? '理科' : '文科';
                },
                'filter' => array('1' => '理科' ,'0' => '文科'),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ]

        ],
    ]); ?>
</div>
