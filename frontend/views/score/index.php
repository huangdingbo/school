<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ScoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学生成绩查询';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-index">

    <p>
            <?php echo Html::a('导出学生成绩', ['index',
                "ScoreSearch[cand_id]"=>isset($searchCondition["ScoreSearch"]["cand_id"]) ? $searchCondition["ScoreSearch"]["cand_id"] : '',
                "ScoreSearch[name]"=>isset($searchCondition["ScoreSearch"]["name"]) ? $searchCondition["ScoreSearch"]["name"] : '',
                "ScoreSearch[test_name]"=>isset($searchCondition["ScoreSearch"]["test_name"]) ? $searchCondition["ScoreSearch"]["test_name"] : '',
                "ScoreSearch[chinese]"=>isset($searchCondition["ScoreSearch"]["chinese"]) ? $searchCondition["ScoreSearch"]["chinese"] : '',
                "ScoreSearch[grade]"=>isset($searchCondition["ScoreSearch"]["grade"]) ? $searchCondition["ScoreSearch"]["grade"] : '',
                "ScoreSearch[banji]"=>isset($searchCondition["ScoreSearch"]["banji"]) ? $searchCondition["ScoreSearch"]["banji"] : '',
                "ScoreSearch[duty]"=>isset($searchCondition["ScoreSearch"]["duty"]) ? $searchCondition["ScoreSearch"]["duty"] : '',
                "ScoreSearch[math]"=>isset($searchCondition["ScoreSearch"]["math"]) ? $searchCondition["ScoreSearch"]["math"] : '',
                "ScoreSearch[english]"=>isset($searchCondition["ScoreSearch"]["english"]) ? $searchCondition["ScoreSearch"]["english"] : '',
                "ScoreSearch[physics]"=>isset($searchCondition["ScoreSearch"]["physics"]) ? $searchCondition["ScoreSearch"]["physics"] : '',
                "ScoreSearch[chemistry]"=>isset($searchCondition["ScoreSearch"]["chemistry"]) ? $searchCondition["ScoreSearch"]["chemistry"] : '',
                "ScoreSearch[biology]"=>isset($searchCondition["ScoreSearch"]["biology"]) ? $searchCondition["ScoreSearch"]["biology"] : '',
                "ScoreSearch[politics]"=>isset($searchCondition["ScoreSearch"]["politics"]) ? $searchCondition["ScoreSearch"]["politics"] : '',
                "ScoreSearch[history]"=>isset($searchCondition["ScoreSearch"]["history"]) ? $searchCondition["ScoreSearch"]["history"] : '',
                "ScoreSearch[geography]"=>isset($searchCondition["ScoreSearch"]["geography"]) ? $searchCondition["ScoreSearch"]["geography"] : '',
                "ScoreSearch[total]"=>isset($searchCondition["ScoreSearch"]["total"]) ? $searchCondition["ScoreSearch"]["total"] : '',
                "ScoreSearch[class_rank]"=>isset($searchCondition["ScoreSearch"]["class_rank"]) ? $searchCondition["ScoreSearch"]["class_rank"] : '',
                "ScoreSearch[school_rank]"=>isset($searchCondition["ScoreSearch"]["school_rank"]) ? $searchCondition["ScoreSearch"]["school_rank"] : '',
                "ScoreSearch[type]"=>isset($searchCondition["ScoreSearch"]["type"]) ? $searchCondition["ScoreSearch"]["type"] : '',
                "ScoreSearch[isExport]"=>'1',
                ], ['class' => 'btn btn-success']) ?>
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
            'cand_id',
            'name',
            [
                'attribute' => 'test_name',
                'label' => '考试名',
                'value' => 'test_name',
                'filter' => \frontend\models\Test::find()
                    ->select('test_name,test_name')
                    ->indexBy('test_name')
                    ->orderBy('id desc')
                    ->column(),
            ],
            [
                'attribute' => 'grade',
                'label' => '届',
                'value' => 'grade',
                'filter' => \frontend\models\Grade::find()
                    ->select('the,the')
                    ->indexBy('the')
                    ->orderBy('id asc')
                    ->column(),
            ],
            [
                'attribute' => 'banji',
                'label' => '班级',
                'value' => 'banji',
                'filter' => \frontend\models\Class0::find()
                    ->select('name,name')
                    ->indexBy('name')
                    ->orderBy('id asc')
                    ->column(),
            ],
            [
                'attribute' => 'test_room',
                'label' => '考场',
                'value' => 'test_room',
                'filter' => \frontend\models\Room::find()
                    ->select('name,name')
                    ->indexBy('name')
                    ->orderBy('id asc')
                    ->column(),
            ],
            'chinese',
            'math',
            'english',
            [
                'attribute' => 'physics',
                'value' => 'physics',
                'visible'=> ($type == 1)
            ],
            [
                'attribute' => 'chemistry',
                'value' => 'chemistry',
                'visible'=> ($type == 1)
            ],
            [
                'attribute' => 'biology',
                'value' => 'biology',
                'visible'=> ($type == 1)
            ],
            [
                'attribute' => 'politics',
                'value' => 'politics',
                'visible'=> ($type == 0)

            ],
            [
                'attribute' => 'history',
                'value' => 'history',
                'visible'=>($type == 0)
            ],
            [
                'attribute' => 'geography',
                'value' => 'geography',
                'visible'=>($type == 0)
            ],
            'total',
            'class_rank',
            'school_rank',
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
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-saved"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','修改'),
                            'aria-label' => Yii::t('yii','修改'),
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'class' => 'data-update',
                            'data-id' => $key,
                        ],['color'=>'red']);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','查看'),
                            'aria-label' => Yii::t('yii','查看'),
                            'data-toggle' => 'modal',
                            'data-target' => '#view-modal',
                            'class' => 'data-view',
                            'data-id' => $key,
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php

    // 更新操作
    Modal::begin([
        'id' => 'update-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">修改</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => 'modal-lg',
    ]);
    Modal::end();
    $requestUpdateUrl = Url::toRoute('update');
    $updateJs = <<<JS
    $('.data-update').on('click', function () {
        $.get('{$requestUpdateUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
    $this->registerJs($updateJs);
    ?>

    <?php

    // 查看操作
    Modal::begin([
        'id' => 'view-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">查看</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => 'modal-lg',
    ]);
    Modal::end();
    $requestViewUrl = Url::toRoute('view');
    $viewJs = <<<JS
    $('.data-view').on('click', function () {
        $.get('{$requestViewUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
    $this->registerJs($viewJs);
    ?>
</div>