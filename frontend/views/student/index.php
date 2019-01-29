<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//echo "<pre>";
//var_dump($searchCondition["StudentSearch"]);exit;
$this->title = '学生档案管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

<!--    <h1> Html::encode($this->title) </h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加学生信息', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('导入学生信息', ['import'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('导出学生信息', ['index',
            "StudentSearch[student_id]"=>isset($searchCondition["StudentSearch"]["student_id"]) ? $searchCondition["StudentSearch"]["student_id"] : '',
            "StudentSearch[test_id]"=>isset($searchCondition["StudentSearch"]["test_id"]) ? $searchCondition["StudentSearch"]["test_id"] : '',
            "StudentSearch[name]"=>isset($searchCondition["StudentSearch"]["name"]) ? $searchCondition["StudentSearch"]["name"] : '',
            "StudentSearch[sex]"=>isset($searchCondition["StudentSearch"]["sex"]) ? $searchCondition["StudentSearch"]["sex"] : '',
            "StudentSearch[grade]"=>isset($searchCondition["StudentSearch"]["grade"]) ? $searchCondition["StudentSearch"]["grade"] : '',
            "StudentSearch[banji]"=>isset($searchCondition["StudentSearch"]["banji"]) ? $searchCondition["StudentSearch"]["banji"] : '',
            "StudentSearch[duty]"=>isset($searchCondition["StudentSearch"]["duty"]) ? $searchCondition["StudentSearch"]["duty"] : '',
            "StudentSearch[political_landscape]"=>isset($searchCondition["StudentSearch"]["political_landscape"]) ? $searchCondition["StudentSearch"]["political_landscape"] : '',
            "StudentSearch[type]"=>isset($searchCondition["StudentSearch"]["type"]) ? $searchCondition["StudentSearch"]["type"] : '',
            "StudentSearch[isExport]"=>'1',
            ], ['class' => 'btn btn-info']) ?>
        <?= Html::a('模板下载', ['create'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'student_id',
            'test_id',
            'name',
//            'sex',
        [
            'attribute' => 'sex',
            'label' => '性别',
            'value' => function($dataProvider){
                return $dataProvider->sex == 1 ? '男' : '女';
            },
            'filter' => array('1' => '男' ,'2' => '女')
        ],
            //'born_time',
            'grade',
            'banji',
            'duty',
            //'home_address',
            //'admission_time',
            'political_landscape',
            //'pic',
//            'type',
            [
                'attribute' => 'type',
                'label' => '类型',
                'value' => function($dataProvider){
                    return $dataProvider->sex == 1 ? '理科' : '文科';
                },
                'filter' => array('1' => '理科' ,'0' => '文科')
            ],
            //'grade_class',
            //'insert_time',
            //'update_time',

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
        'header' => '<h4 class="modal-title">修改</h4>',
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
        'header' => '<h4 class="modal-title">查看</h4>',
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
