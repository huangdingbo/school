<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cases-index">


    <p>
        <?= Html::a('创建事件', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'selectedType',
                'label' => '模块',
                'value' => function($dataProvider){
                    if ($dataProvider->create_id == Yii::$app->user->id){
                        return '由我创建';
                    }
                    if ($dataProvider->point_id == Yii::$app->user->id && $dataProvider->create_id != Yii::$app->user->id ){
                        return '指派给我';
                    }
                },
                'filter' => ['1' => '由我创建','2' => '指派给我'],
            ],
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
                'template' => '{view}{point}{solve}{activation}{delete}',
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
                    'point' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-hand-up"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','指派'),
                            'aria-label' => Yii::t('yii','指派'),
                            'data-toggle' => 'modal',
                            'data-target' => '#point-modal',
                            'class' => 'data-point',
                            'data-id' => $key,
                        ]);
                    },
                    'solve' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-ok"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','解决'),
                            'aria-label' => Yii::t('yii','解决'),
                            'data-toggle' => 'modal',
                            'data-target' => '#solve-modal',
                            'class' => 'data-solve',
                            'data-id' => $key,
                        ]);
                    },
                    'activation' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-open"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','激活'),
                            'aria-label' => Yii::t('yii','激活'),
                            'data-toggle' => 'modal',
                            'data-target' => '#activation-modal',
                            'class' => 'data-activation',
                            'data-id' => $key,
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
<!--    --><?php
//    // 更新操作
//    Modal::begin([
//        'id' => 'update-modal',
//        'header' => '<h4 class="modal-title" style="color: #0d6aad">修改</h4>',
//        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
//        'size' => 'modal-lg',
//    ]);
//    Modal::end();
//    $requestUpdateUrl = Url::toRoute('update');
//    $updateJs = <<<JS
//    $('.data-update').on('click', function () {
//        $.get('{$requestUpdateUrl}', { id: $(this).closest('tr').data('key') },
//            function (data) {
//                $('.modal-body').html(data);
//            }
//        );
//    });
//JS;
//    $this->registerJs($updateJs);
//    ?>

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
    //指派操作
    Modal::begin([
        'id' => 'point-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">指派</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => 'modal-lg',
    ]);
    Modal::end();
    $requestPointUrl = Url::toRoute('point');
    $pointJs = <<<JS
    $('.data-point').on('click', function () {
        $.get('{$requestPointUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
    $this->registerJs($pointJs);
    ?>
    <?php
    //解决操作
    Modal::begin([
        'id' => 'solve-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">解决</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => 'modal-lg',
    ]);
    Modal::end();
    $requestSolveUrl = Url::toRoute('solve');
    $solveJs = <<<JS
    $('.data-solve').on('click', function () {
        $.get('{$requestSolveUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
    $this->registerJs($solveJs);
    ?>
    <?php
    //激活操作
    Modal::begin([
        'id' => 'activation-modal',
        'header' => '<h4 class="modal-title" style="color: #0d6aad">激活</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => 'modal-lg',
    ]);
    Modal::end();
    $requestActivationUrl = Url::toRoute('activation');
    $activationJs = <<<JS
    $('.data-activation').on('click', function () {
        $.get('{$requestActivationUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
    $this->registerJs($activationJs);
    ?>
</div>
