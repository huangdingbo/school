<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/12
 * Time: 17:53
 */

namespace api\models;


use common\models\config;
use frontend\models\Cases;
use frontend\models\Kaohao;
use frontend\models\Test;
use yii\base\Model;

class CockpitModel extends Model
{
    const GRADE_ONE = 1; //高一
    const GRADE_TWO = 2; //高二
    const GRADE_THREE = 3; //高三
    const STUDENT_LIKE = 1; //理科
    const STUDENT_WENKE = 2; //文科

    /**
     * @param $grade
     * @param $type
     * @return array|\yii\db\ActiveRecord[]
     * 获取一个年级一年的本科上线率
     */
    public static function getYearRatio($grade,$type){
        $start = date('Y',time()).'-01-01 00:00:00';
        $end = date('Y',time()).'-12-31 23:59:59';
        //获取考试列表
        $testList = Test::find()->leftJoin('wire','test.test_num = wire.test_num')
            ->select('	test.test_num,test.test_name,wire.benke_num')
            ->where(['test.grade_num' => $grade,'test.status' => '2','test.type' => $type])
            ->andWhere(['>=','test.insert_time',$start])
            ->andWhere(['<=','test.insert_time',$end])
            ->orderBy('test.insert_time asc')
            ->asArray()->all();
        foreach ($testList as &$aitem){
            $aitem['studentNum'] = static::getTestStudentNum($aitem['test_num']);
            $aitem['ratio'] = (string)(round(($aitem['benke_num'] /  $aitem['studentNum'])*100,'2'));
        }
       return $testList;
    }

    /**
     * @param $testNum
     * @return int|string
     * 获取每次考试人数
     */
    public static function getTestStudentNum($testNum){
        $num = Kaohao::find()->where(['test_num' => $testNum])->count();
        return $num;
    }

    /**
     * 获取校园案件总量
     */
    public static function getCaseTotalNum(){
        $num = Cases::find()->count();
        return $num;
    }

    /**
     * 日均案件量
     */

    public static function getCaseAvgDayNum(){
        $startArr = Cases::find()->select('MIN(insert_time) as start')->asArray()->one();
        $start = strtotime($startArr['start']);
        $endArr = Cases::find()->select('MAX(insert_time) as end')->asArray()->one();
        $end = strtotime($endArr['end']);
        //相隔天数
        $days = (static::timeDiff($start,$end))['day'];
        //总案件量
        $total = self::getCaseTotalNum();
        //日均案件量
        $caseAvg = (string)(round(($total / $days),'2')) ;

        return $caseAvg;
    }

    /**
     * 事件受理率
     */
    public static function getAcceptRatio(){
        //受理事件
        $acceptNum = Cases::find()->where(['status' => '2'])->count();
        //总事件
        $total = self::getCaseTotalNum();
        $acceptRatio = (string)(round(($acceptNum / $total)*100,'2')) ;
        return $acceptRatio;
    }

    /**
     * 事件高发类型TOP6
     */
    public static function getCaseHighType(){
        //事件总数
        $total = self::getCaseTotalNum();
        $list = Cases::find()->select('type as name,count(*) as value')
            ->groupBy('name')
            ->orderBy('value desc')
            ->limit('6')
            ->asArray()
            ->all();
        foreach ($list as &$aitem){
            $aitem['name'] = config::$caseType[$aitem['name']];
            $aitem['ratio'] = (string)(round(($aitem['value'] / $total)*100,'2')) ;
        }
       return $list;
    }

    /**
     * 计算两个时间戳相隔天数
     */

    public static function timeDiff($begin_time,$end_time){
        if($begin_time < $end_time){
            $starttime = $begin_time;
            $endtime = $end_time;
        }else{
            $starttime = $end_time;
            $endtime = $begin_time;
        }

        //计算天数
        $timediff = $endtime-$starttime;
        $days = intval($timediff/86400);
        //计算小时数
        $remain = $timediff%86400;
        $hours = intval($remain/3600);
        //计算分钟数
        $remain = $remain%3600;
        $mins = intval($remain/60);
        //计算秒数
        $secs = $remain%60;
        $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
        return $res;
    }
}