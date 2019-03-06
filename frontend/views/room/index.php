<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '考场设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-index">

    <p>
        <?= Html::a('创建考场', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => '考试名',
                'value' => 'name',
                'filter' => \frontend\models\Room::find()
                    ->select('name,name')
                    ->indexBy('name')
                    ->column(),
            ],
            [
                'attribute' => 'location',
                'label' => '位置',
                'value' => 'location',
                'filter' => $locationMap,
            ],
            [
                'attribute' => 'grade',
                'label' => '届',
                'value' => 'grade0.the',
                'filter' => \frontend\models\Grade::find()
                    ->select('the,id')
                    ->indexBy('id')
                    ->column(),
            ],
            'num',

            [
                'attribute' => 'teachers',
                'label' => '监考老师',
                'value' => function($dataProvider){
                    $list = json_decode($dataProvider->teachers);
                    if (is_array($list)){
                        $count = count($list);
                        $str = '';
                        for ($i=0;$i<$count;$i++){
                            if ($i == ($count-1)){
                                $str .= $list[$i];
                            }else{
                                $str .= $list[$i].',';
                            }
                        }
                        return $str;
                    }
                   return "未设置";

                },
            ],
            'insert_time',
            'update_time',

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
</div>
