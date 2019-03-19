<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/18
 * Time: 19:06
 */

namespace api\controllers;


use api\models\ReadGradeModel;
use api\models\WarningIndexModel;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class WarningIndexController extends MyController
{
    /**
     * @return array
     * @throws ForbiddenHttpException
     * 预警首页头部
     */
    public function actionHeader(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $studentType = isset($postData['studentType']) ? $postData['studentType'] : '';
        $testNum = isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $class = isset($postData['class']) ? $postData['class'] : '';
        if (!$grade){
            throw new ForbiddenHttpException('缺少年级');
        }
        if (!$studentType){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = WarningIndexModel::getWarningNum($testNum,$type,$studentType,$grade,$class);

        return [
            'list' => $list
        ];
    }

    /**
     * @return array
     * 年级列表
     */
    public function actionGradeList(){
        $list = WarningIndexModel::getGradeList();

        return [
            'list' => $list
        ];
    }

    /**
     * @return array
     * 班级列表
     */
    public function actionClassList(){
        $list = WarningIndexModel::getClassList();

        return [
            'list' => $list
        ];
    }

    public function actionHighRisk(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $list = WarningIndexModel::getHighRiskStudent($grade,$type);
        return [
            'list' => $list
        ];
    }

    public function actionWarningType(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $list = WarningIndexModel::getWarningTypeData($grade,$type);

        return [
            'list' => $list
        ];
    }

    public function actionWarningWork(){
        $list = WarningIndexModel::getWarningWorkList();

        return [
            'list' => $list
        ];
    }

    public function actionWarningDevelop(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $class = isset($postData['class']) ? $postData['class'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $studentType = isset($postData['studentType']) ? $postData['studentType'] : '';
        if (!$grade){
            throw new ForbiddenHttpException('缺少年级');
        }
        if (!$studentType){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = WarningIndexModel::getWarningDevelopList($grade,$class,$type,$studentType);

        return [
            'list' => $list
        ];
    }

    public function actionWarningStatistical(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $class = isset($postData['class']) ? $postData['class'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $studentType = isset($postData['studentType']) ? $postData['studentType'] : '';
        $test = isset($postData['test']) ? $postData['test'] : '';
        if (!$grade){
            throw new ForbiddenHttpException('缺少年级');
        }
        if (!$studentType){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少预警类型');
        }

        $list = WarningIndexModel::getWarningStatisticalList($grade,$class,$type,$studentType,$test);

        return [
            'list' => $list
        ];
    }

    public function actionWarningAll(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $class = isset($postData['class']) ? $postData['class'] : '';
        $test = isset($postData['test']) ? $postData['test'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $studentType = isset($postData['studentType']) ? $postData['studentType'] : '';
        $course = isset($postData['course']) ? $postData['course'] : '';
        $status = isset($postData['status']) ? $postData['status'] : '';
        $nameStr = isset($postData['nameStr']) ? $postData['nameStr'] : '';

        $list = WarningIndexModel::getWarningAllList($grade,$class,$test,$type,$studentType,$course,$status,$nameStr);

        return [
            'list' => $list
        ];
    }

    public function actionWarningDetail(){
        $postData = \Yii::$app->request->post();
        $id =  isset($postData['id']) ? $postData['id'] : '';
        if (!$id){
            throw new ForbiddenHttpException('缺少预警id');
        }
        $list = WarningIndexModel::getWarningDetail($id);

        return $list;
    }

    public function actionTestList(){
        $postData = \Yii::$app->request->post();
        $type = isset($postData['type']) ? $postData['type'] : '';
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        if (!$type){
            throw new ForbiddenHttpException('缺少学生类型，1理科2文科');
        }
        if (!$grade){
            throw new ForbiddenHttpException('缺少年级');
        }
        $list = WarningIndexModel::getTestList($type,$grade);
        return $list;
    }

   public function actionTypeList(){
        $types = WarningIndexModel::$warningType;
        $list = array();
        foreach ($types as $key => $item){
            $list[] = [
                'name' => $item,
                'value' => $key
            ];
        }
        return $list;
   }

   public function actionCourseList(){
       $postData = \Yii::$app->request->post();
       $type = isset($postData['type']) ? $postData['type'] : '';

       return ReadGradeModel::NumConfig($type);
   }
}