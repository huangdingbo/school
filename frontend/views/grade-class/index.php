<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GradeClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-class-index">


    <p>
        <?= Html::a('添加基础信息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'grade',
                'label' => '届',
                'value'=> 'grade0.the',
                'filter' =>  \frontend\models\Grade::find()
                        ->select('the,id')
                        ->indexBy('the')
                        ->column(),
                'headerOptions' => ['width' => '150'],
            ],
            [
                'attribute' => 'banji',
                'label' => '班级',
                'value'=> 'class0.name',
                'filter' =>  \frontend\models\Class0::find()
                    ->select('name,id')
                    ->indexBy('name')
                    ->column(),
                'headerOptions' => ['width' => '150'],
            ],
            [
                'attribute' => 'status',
                'label' => '状态',
                'value'=> function($dataProvider){
                    return $dataProvider->status == 1 ? '已排' : '未排';
                },
                'filter' =>['0' => '未排','1' => '已排'],
                'headerOptions' => ['width' => '150'],
                'contentOptions' => function($dataProvider){
                    return $dataProvider->status == 0 ? ['class' => 'bg-danger'] : ['class' => 'bg-success'];
                },
            ],
            'insert_time',
            'update_time',

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{arranging}{export}{delete}',
                'buttons' => [
                    'arranging' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-saved"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','排课'),
                            'aria-label' => Yii::t('yii','排课'),
                            'class' => 'data-update',
                            'data-id' => $key,
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','查看课表'),
                            'aria-label' => Yii::t('yii','查看课表'),
                            'data-toggle' => 'modal',
                            'data-target' => '#view-modal',
                            'class' => 'data-view',
                            'data-id' => $key,
                        ]);
                    },
                    'export' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-save-file"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','导出课表'),
                            'aria-label' => Yii::t('yii','导出课表'),
                            'class' => 'data-view',
                            'data-id' => $key,
                        ]);
                    },
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
</div>
