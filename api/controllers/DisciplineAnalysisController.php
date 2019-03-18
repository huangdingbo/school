<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/17
 * Time: 14:03
 */

namespace api\controllers;


use api\models\DisciplineAnalysisModel;
use api\models\ReadGradeModel;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class DisciplineAnalysisController extends  MyController
{
    public function actionProfile(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = DisciplineAnalysisModel::getProfileDataForCourse($testNum,$type);

        return [
            'list' => $list
        ];
    }

    public function actionSingleScale(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $course = isset($postData['course']) ? $postData['course'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$course){
            throw new ForbiddenHttpException('缺少学科');
        }

        $list = DisciplineAnalysisModel::getSingleScaleData($testNum,$course);

        return [
            'list' => $list
        ];
    }

    public function actionCourseList(){
        $postData = \Yii::$app->request->post();
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = ReadGradeModel::NumConfig($type);

       return [
           'list' => $list
       ];
    }
}