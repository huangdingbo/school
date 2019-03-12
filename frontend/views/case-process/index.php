<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CaseProcessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Case Processes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="case-process-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Case Process', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'case_num',
            'process',
            'instructions:ntext',
            'pic',
            //'date_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
