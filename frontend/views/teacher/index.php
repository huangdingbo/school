<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchCondition */
$this->title = '教师档案管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加教师信息', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('导入教师信息', ['import'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('导出教师信息', ['index',
            "TeacherSearch[teacher_id]"=>isset($searchCondition["TeacherSearch"]["teacher_id"]) ? $searchCondition["TeacherSearch"]["teacher_id"] : '',
            "TeacherSearch[name]"=>isset($searchCondition["TeacherSearch"]["name"]) ? $searchCondition["TeacherSearch"]["name"] : '',
            "TeacherSearch[sex]"=>isset($searchCondition["TeacherSearch"]["sex"]) ? $searchCondition["TeacherSearch"]["sex"] : '',
            "TeacherSearch[duty]"=>isset($searchCondition["TeacherSearch"]["duty"]) ? $searchCondition["TeacherSearch"]["duty"] : '',
            "TeacherSearch[political_landscape]"=>isset($searchCondition["TeacherSearch"]["political_landscape"]) ? $searchCondition["TeacherSearch"]["political_landscape"] : '',
            "TeacherSearch[title]"=>isset($searchCondition["TeacherSearch"]["title"]) ? $searchCondition["TeacherSearch"]["title"] : '',
            "TeacherSearch[diploma]"=>isset($searchCondition["TeacherSearch"]["diploma"]) ? $searchCondition["TeacherSearch"]["diploma"] : '',
            "TeacherSearch[isExport]"=>'1',
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
                'attribute' => 'teacher_id',
                'value' => 'teacher_id',
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
                'attribute' => 'duty',
                'label' => '职务',
                'value' => 'duty0.name',
                'filter' => \frontend\models\Duty::find()
                    ->select('name,id')
                    ->indexBy('id')
                    ->column(),
            ],
            [
                'attribute' => 'diploma',
                'label' => '学历',
                'value' => 'diploma0.name',
                'filter' => \frontend\models\Diploma::find()
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
                'attribute' => 'title',
                'label' => '职称',
                'value' => 'title0.name',
                'filter' => \frontend\models\Title::find()
                    ->select('name,id')
                    ->indexBy('id')
                    ->column(),
            ],
            [
                'attribute' => 'group',
                'label' => '所在分组',
                'value' => function($dataProvider){
                    return Yii::$app->params['groupConfig'][$dataProvider->group];
                },
                'filter' => Yii::$app->params['groupConfig'],
            ],
           'tel',
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
