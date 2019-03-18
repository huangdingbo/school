<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/16
 * Time: 19:13
 */

namespace api\controllers;


use api\models\ClassAnalysisModel;
use frontend\models\Score;
use frontend\models\Test;
use yii\web\ForbiddenHttpException;

class ClassAnalysisController extends  MyController
{
    /**
     * @return array
     * 学生构成分析
     */
    public function actionConstitute(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }
        //获取列表
        $list = ClassAnalysisModel::getStudentConstituteForClass($testNum,$type);
        return [
            'list' => $list
        ];
    }

    public function actionAvgRank(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = ClassAnalysisModel::getAvgRankForClass($testNum,$type);

        return [
            'list' => $list
        ];
    }

    public function actionHistoryAvgRank(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }

        $list = ClassAnalysisModel::getHistoryAvgRankForClass($testNum);

        return [
            'list' => $list
        ];
    }

    public function actionStable(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        $grade = (Test::findOne(['test_num' => $testNum]))->grade_num;
        $list = ClassAnalysisModel::getStableForClass($grade);

        return [
            'list' => $list
        ];
    }

}