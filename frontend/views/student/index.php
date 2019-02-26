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
        <?= Html::a('模板下载', ['download'], ['class' => 'btn btn-warning']) ?>
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
                'attribute' => 'student_id',
                'value' => 'student_id',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'test_id',
                'value' => 'test_id',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'name',
                'value' => 'name',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value' => function($dataProvider){
                    return $dataProvider->sex == 1 ? '男' : '女';
                },
                'filter' => array('1' => '男' ,'2' => '女'),
            ],
            [
                'attribute' => 'grade',
                'label' => '年级',
                'value' => 'grade0.name',
                'filter' => \frontend\models\Grade::find()
                    ->select('name,the')
                    ->indexBy('the')
                    ->column(),
            ],
            [
                'attribute' => 'banji',
                'label' => '班级',
                'value' => 'class0.name',
                'filter' => \frontend\models\Class0::find()
                    ->select('name,id')
                    ->indexBy('id')
                    ->column(),
            ],
            [
                'attribute' => 'duty',
                'label' => '职务',
                'value' => 'duty0.name',
                'filter' => \frontend\models\Duty::find()
                    ->select('name,id')
                    ->indexBy('id')
                    ->column(),
            ],
            [
                'attribute' => 'political_landscape',
                'label' => '政治面貌',
                'value' => 'political0.name',
                'filter' => \frontend\models\Political::find()
                    ->select('name,id')
                    ->indexBy('id')
                    ->column(),
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
