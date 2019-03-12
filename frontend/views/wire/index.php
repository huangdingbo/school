<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wires';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wire-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wire', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'test_num',
            'benke_wire',
            'zhongben_wire',
            'benke_num',
            //'zhongben_num',
            //'insert_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
