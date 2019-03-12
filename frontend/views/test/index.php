<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '考试信息管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">


    <p>
        <?= Html::a('发布考试', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'test_num',
            'test_name',
            [
                'attribute' => 'grade_num',
                'label' => '届',
                'value' => 'grade0.the',
                'filter' => \frontend\models\Grade::find()
                    ->select('the,id')
                    ->indexBy('id')
                    ->column(),
            ],
            [
                'attribute' => 'status',
                'label' => '状态',
                'value' => function($dataProvider){
                    return $dataProvider->status == 1 ? '正在进行' : '已结束';
                },
                'contentOptions' => function($model){
                    return $model->status == 1 ? ['class' => 'bg-danger'] : ['class' => 'bg-success'];
                },
                'filter' => array('1' => '正在进行' ,'2' => '已结束')
            ],
            [
                'attribute' => 'type',
                'label' => '类型',
                'value' => function($model){
                    return $model->type == 1 ? '理科' : '文科';
                },
                'filter' => array('1' => '理科' ,'0' => '文科')

            ],
            'insert_time',
            'update_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{candidate}{entry}{wire}{audit}{delete}',
                'buttons' => [
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
                    'candidate' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','生成考号'),
                            'aria-label' => Yii::t('yii','生成考号'),
                            'data-confirm' => Yii::t('yii','你确定要生成本次考试考号吗？'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
//                            'controller'=>'tkaohao',
                        ];
                        return Html::a('<span class = "glyphicon glyphicon-check  "></span>  ',$url,$options);
                    },
                    'entry' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','录入成绩'),
                            'aria-label' => Yii::t('yii','录入成绩'),
                            'data-confirm' => Yii::t('yii','你确定要录入成绩本次考试成绩吗？'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'controller'=>'score',
                        ];
                        return Html::a('<span class = "glyphicon glyphicon-pencil"></span>   ',$url,$options);
                    },
                    'wire' =>function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-list"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','划线'),
                            'aria-label' => Yii::t('yii','划线'),
                            'data-toggle' => 'modal',
                            'data-target' => '#wire-modal',
                            'class' => 'data-wire',
                            'data-id' => $key,
                        ],['color'=>'red']);
                    },
                    'audit' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','结束考试'),
                            'aria-label' => Yii::t('yii','结束考试'),
                            'data-confirm' => Yii::t('yii','你确定要结束本次考试吗？'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
//                            'controller'=>'tkaohao',
                        ];
                        return Html::a('<span class = "glyphicon glyphicon-off"></span>  ',$url,$options);
                    }
                ],
            ],
        ],
    ]); ?>
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
    <?php
    // 更新操作
    Modal::begin([
        'id' => 'update-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">修改</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
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

    // 划线
    Modal::begin([
        'id' => 'wire-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">划线</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    ]);
    Modal::end();
    $requestUpdateUrl = Url::toRoute('wire');
    $updateJs = <<<JS
    $('.data-wire').on('click', function () {
        $.get('{$requestUpdateUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
    $this->registerJs($updateJs);
    ?>
</div>