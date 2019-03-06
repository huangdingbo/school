<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\ScoreSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="score-search">

    <?php $form = ActiveForm::begin([
        'action' => ['test/entry'],
        'method' => 'get',
    ]); ?>
    <div class="table-responsive"></div>
    <input type="hidden" name="id" value=<?=Yii::$app->request->get('id');?>>
    <table class="table">
        <tr>
            <td><?= $form->field($model, 'cand_id')->textInput(['class'=>'form-control','placeholder'=>'输入考号搜索...'])->label(false) ?></td>
            <td><?= $form->field($model, 'name')->textInput(['class'=>'form-control','placeholder'=>'输入姓名搜索...'])->label(false) ?></td>
            <td><?= $form->field($model, 'seat_num')->textInput(['class'=>'form-control','placeholder'=>'输入座位号搜索...'])->label(false) ?></td>

            <td><?php
                $banji = \frontend\models\Class0::find()
                            ->select('name,name')
                            ->indexBy('name')
                            ->orderBy('update_time desc')
                            ->column();
                $allBanji = ['班' => '全部班级'];
                $newBanji = array_merge($allBanji,$banji);
                echo $form->field($model, 'banji')->widget(Select2::classname(), [
                    'data' => $newBanji,
                    'options' => ['placeholder' => '请选择班级 ...'],
                ])->label(false)
                ;?>
            </td>
            <td><?php
                $testRoom = \frontend\models\Kaohao::find()
                            ->select('room_name')
                            ->where(['test_num'=>$testInfo->test_num])
                            ->groupBy('room_name')
                            ->indexBy('room_name')
                            ->column();
                $allRoom = ['考' => '全部考场'];
                $newRoom = array_merge($allRoom,$testRoom);
                echo $form->field($model, 'test_room')->widget(Select2::classname(), [
                    'data' => $newRoom,
                    'options' => ['placeholder' => '请选择考场 ...'],
                ])->label(false)
                ;?>
            </td>
            <td><?php
                $location = \common\models\config::getLocationMap();
                $allLoc = ['届' => '全部考场'];
                $newLoc = array_merge($allLoc,$location);
                echo $form->field($model, 'location')->widget(Select2::classname(), [
                    'data' => $newLoc,
                    'options' => ['placeholder' => '请选择考场位置 ...'],
                ])->label(false)
                ;?>
            </td>
        </tr>
    </table>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>