<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '教师档案管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加教师信息', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('导入教师信息', ['import'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('导出教师信息', ['index',
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
        'layout'=> '{items}<div class="text-left tooltip-demo">{pager}</div>',
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'尾页',
        ],
        'columns' => [
            'teacher_id',
            'name',
            'sex',
            'born_time',
            'grade',
            'banji',
            'duty',
            'diploma',
            'political_landscape',
            'title',

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
