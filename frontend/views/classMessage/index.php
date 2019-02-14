<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\Class0Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '班级档案管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class0-index">

    <p>
        <?= Html::a('添加班级信息', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('更新班级人数', ['update-message'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => '班级',
                'value' => 'class0.name',
                'filter' => \frontend\models\Class0::find()
                    ->select('name,id')
                    ->indexBy('id')
                    ->column(),
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'grade',
                'label' => '年级',
                'value' => 'grade0.name',
                'filter' => \frontend\models\Grade::find()
                    ->select('name,the')
                    ->indexBy('the')
                    ->column(),
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'managers',
                'label' => '班主任',
                'value' => 'manager0.name',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'leadership',
                'label' => '分管领导',
                'value' => 'manager0.name',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'alias',
                'label' => '别名',
                'value' => function($dataProvider){
                    if ($dataProvider->alias == 1){
                        return '火箭班';
                    }elseif ($dataProvider->alias == 2){
                        return '飞机班';
                    }
                    return '普通班';
                },
                'filter' => [
                    '1' => '火箭班',
                    '2' => '飞机班',
                    '3' => '普通班',
                ],
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'num',
                'label' => '人数',
                'value' => function($dataProvider){
                    $numModel = \frontend\models\Student::find()
                        ->where(['banji'=>$dataProvider->name,'grade'=>$dataProvider->grade])
                        ->count();
                    return $numModel.'人';
                },
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'slogan',
                'label' => '口号',
                'value' => 'slogan',
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
