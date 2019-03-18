<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/16
 * Time: 19:15
 */

namespace api\models;


use frontend\models\Class0;
use frontend\models\Kaohao;
use frontend\models\Score;
use frontend\models\Test;
use frontend\models\Wire;
use yii\bootstrap\Modal;

class ClassAnalysisModel extends  Modal
{
    public static function getStudentConstituteForClass($testNum,$type){
        //班级列表
        $classList = Class0::find()->select('name')->asArray()->all();
        //考试分数线
        $wire = Wire::find()->where(['test_num' => $testNum])->one();
        foreach ($classList as &$aitem){
            $data = self::getNumAndRatioForClass($testNum,$type,$aitem['name'],$wire);
            $aitem['totalStudent'] = self::testStudentNumForClass($testNum,$aitem['name']);
            $aitem['zhongben'] = $data['zhongben'];
            $aitem['benke'] = $data['benke'];
            $aitem['offline'] = $data['offline'];
        }
        return $classList;
    }

   /**
    * 获取班级每个学生段的人数及占比
    */
   public static function getNumAndRatioForClass($testNum,$type,$class,$wire){
       //每次考试参考班级人数
       $totalNum = self::testStudentNumForClass($testNum,$class);
       $list = array();
       //重本
        $zhongbenStudent = Score::find()->select('name,total')
            ->where(['test_num' => $testNum,'type' => $type,'banji' => $class])
            ->andWhere(['>=','total',$wire->zhongben_wire])
            ->asArray()
            ->all();
        $zhongbenNum = count($zhongbenStudent);
       $list['zhongben'] = [
           'zhongbenStudent' => $zhongbenStudent,
           'zhongbenNum' => $zhongbenNum,
           'zhongbenRatio' => (string)(round((count($zhongbenStudent) / $totalNum)*100,'2')),
       ];
       //本科
       $benkeStudent = Score::find()->select('name,total')
           ->where(['test_num' => $testNum,'type' => $type,'banji' => $class])
           ->andWhere(['>=','total',$wire->benke_wire])
           ->andWhere(['<','total',$wire->zhongben_wire])
           ->asArray()
           ->all();
       $benkeNum = count($benkeStudent);
       $list['benke'] = [
           'benkeStudent' => $benkeStudent,
           'benkeNum' => $benkeNum,
           'benkeRatio' => (string)(round(($benkeNum / $totalNum)*100,'2')),
       ];
       //未上线
       $offlineStudent = Score::find()->select('name,total')
           ->where(['test_num' => $testNum,'type' => $type,'banji' => $class])
           ->andWhere(['<','total',$wire->benke_wire])
           ->asArray()
           ->all();
       $offlineNum = count($offlineStudent);
       $list['offline'] = [
           'offlineStudent' => $offlineStudent,
           'offlineNum' => $offlineNum,
           'offlineRatio' => (string)(round(($offlineNum / $totalNum)*100,'2')),
       ];

        return $list;
   }

   public static function testStudentNumForClass($testNum,$class){
       $num = Score::find()->where(['test_num' => $testNum,'banji' => $class])->count();
       return $num;
   }

   public static function getAvgRankForClass($testNum,$type){
       $classList = Class0::find()->select('name')->asArray()->all();
       foreach ($classList as &$aitem){
           //每次考试参考班级人数
           $scoreList = Score::find()->select('avg(total) as avg')
               ->where(['test_num' => $testNum,'banji' => $aitem['name']])
               ->asArray()
               ->one();
           $aitem['avg'] = (string)(round($scoreList['avg'],'0'));
       }
       $sortList = CommonModel::arraySort($classList,'avg');
       foreach ($sortList as $key => &$aitem){
           $aitem['rank'] = $key + 1;
       }
        return $sortList;
   }

    public static function getHistoryAvgRankForClass($testNum){
       $grade = (Test::findOne(['test_num' => $testNum]))->grade_num;
       $testList = Test::find()->select('test_num as testNum,test_name as testName')
           ->where(['grade_num' => $grade])
           ->orderBy('insert_time asc')
           ->asArray()
           ->all();
        $classList = Class0::find()->select('name')->asArray()->all();
        foreach ($classList as &$aitem){
            foreach ($testList as $key => $test){
                $scoreList = Score::find()->select('avg(total) as avg')
                    ->where(['test_num' => $test['testNum'],'banji' => $aitem['name']])
                    ->asArray()
                    ->one();
                $aitem['data'][$key] = [
                    'testName' => $test['testName'],
                    'avg' => (string)(round($scoreList['avg'],'0')),
                ];
                $aitem['data'] = CommonModel::arraySort($aitem['data'],'avg');
                foreach ($aitem['data'] as $k => &$a){
                    $a['rank'] = $k + 1;
                }
            }

        }
        return $classList;
    }

    public static function getStableForClass($grade){
       $testList = Test::find()->select('test_name as testName,test_num as testNum')
           ->where(['grade_num' => $grade])
           ->orderBy('insert_time asc')
           ->asArray()
           ->all();
       $classList = Class0::find()->select('name')->asArray()->all();
       foreach ($classList as &$value){
           foreach ($testList as &$aitem){
               $wire = (Wire::findOne(['test_num' => $aitem['testNum']]))->benke_wire;
               $num = Score::find()->where(['test_num' => $aitem['testNum']])
                   ->andWhere(['banji' => $value['name']])
                   ->andWhere(['>=','total',$wire])
                   ->count();
               $value['data'][] = [
                   'testName' => $aitem['testName'],
                   'num' => $num,
                   'joinNum' =>  $totalNum = self::testStudentNumForClass($aitem['testNum'],$value['name']),
               ];
           }
       }
       return $classList;
    }
}