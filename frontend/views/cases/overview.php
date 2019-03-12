<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '校园事件概览';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cases-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'case_num',
            [
                'attribute' => 'type',
                'label' => '类型',
                'value' => function($dataProvider){
                    return \common\models\config::$caseType[$dataProvider->type];
                },
                'filter' => \common\models\config::$caseType,
            ],
            'title',
            [
                'attribute' => 'create_id',
                'label' => '创建人',
                'value' => function($dataProvider){
                    return (\frontend\models\Adminuser::findOne(['id' => $dataProvider->create_id]))->nickname;
                },
            ],
            [
                'attribute' => 'status',
                'label' => '当前状态',
                'value' => function($dataProvider){
                    return \common\models\config::$caseStatus[$dataProvider->status];
                },
                'contentOptions' => function($dataProvider){
                    return $dataProvider->status == 1 ? ['class' => 'bg-danger'] : ['class' => 'bg-success'];
                },
                'filter' => \common\models\config::$caseStatus,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-eye-open"></span>', $url, [
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
