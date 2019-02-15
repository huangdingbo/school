<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DutySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$type = (Yii::$app->request->get())['type'];
$this->title = $type == '1' ? '学生职务表配置' : '教师职务表配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="duty-index">


    <p>
        <?= Html::a('添加职务', ['create','type'=>$type], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'name',
                'value' => 'name',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'type',
                'label' => '类型',
                'value' => function($dataProvider){
                    return $dataProvider->type == 1 ? '学生' : '教师';
                },
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'insert_time',
                'value' => 'insert_time',
                'headerOptions' => ['width' => '180'],
            ],
            [
                'attribute' => 'update_time',
                'value' => 'update_time',
                'headerOptions' => ['width' => '180'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
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
                    'delete' => function ($url, $model, $key) {
                        $type = (Yii::$app->request->get())['type'];
                        $options = [
                            'title' => Yii::t('yii','删除'),
                            'aria-label' => Yii::t('yii','删除'),
                            'data-confirm' => Yii::t('yii','你确定要删除此项吗？'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
//                            'controller'=>'tkaohao',
                        ];
                        return Html::a('<span class = "glyphicon glyphicon-trash"></span> ',$url.'&type='.$type,$options);
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
</div>
