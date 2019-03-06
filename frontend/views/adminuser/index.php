<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <p>
        <?= Html::a('添加管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'nickname',
            'email:email',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{resetpwd}{privilege}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class = "glyphicon glyphicon-eye-open"> </span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('yii','查看'),
                                'aria-label' => Yii::t('yii','查看'),
                                'data-toggle' => 'modal',
                                'data-target' => '#view-modal',
                                'class' => 'data-view',
                                'data-id' => $key,
                            ]);
                        },
                            'resetpwd' => function($url,$model,$key){
                                $options = [
                                    'title' => Yii::t('yii','重置密码'),
                                    'aria-label' => Yii::t('yii','重置密码'),
                                    'data-pajx' => '0',
                                ];
                                return Html::a('<span class="glyphicon glyphicon-lock"> </span>',$url,$options);
                            },
                            'privilege' => function($url,$model,$key){
                                $options = [
                                    'title' => Yii::t('yii','权限设置'),
                                    'aria-label' => Yii::t('yii','权限设置'),
                                    'data-pajx' => '0',
                                ];
                                return Html::a('<span class="glyphicon glyphicon-user"> </span>',$url,$options);
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
