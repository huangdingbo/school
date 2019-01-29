<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Student */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-view">

    <h1><?= Html::img($model->pic,['height'=>'100','width'=>'100']) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'student_id',
            'test_id',
            'sex',
            'born_time',
            'grade',
            'banji',
            'duty',
            'home_address',
            'admission_time',
            'political_landscape',
            'type',
            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>
