<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/7
 * Time: 22:27
 */

namespace api\models;


use frontend\models\Grade;
use frontend\models\Score;
use frontend\models\Test;
use frontend\models\Wire;
use yii\base\Model;

class CommonModel extends Model
{
    //获取最新考试
    public static function getNewTest(){
        $newTest = Test::find()->select('test_num')
            ->orderBy('insert_time desc,grade_num asc')
            ->asArray()
            ->one();
        return $newTest;
    }

    //获取本年度各年级的本科上线情况
    public static function getUndergraduateOnline(){
        $wire = 425;
        $gradeList = static::getGrade();
        $start = date('Y',time()).'-01-01 00:00:00';
        $end = date('Y',time()).'-12-31 23:59:59';
        $list = array();
        foreach ($gradeList as $item){
            $three = Score::find()
                ->where(['>=','total',$wire])
                ->andWhere(['>=','insert_time',$start])
                ->andWhere(['<=','insert_time',$end]);

        }
    }

    public static function getGrade()
    {
        $list = Grade::find()->select('id,the,name')
            ->orderBy('the desc')
            ->limit('3')
            ->all();

        return $list;
    }

    /**
     * @param $testNum
     * @return Wire|null
     * 获取考试分数线
     */
    public static function getTestWire($testNum){
        $item = Wire::findOne(['test_num' => $testNum]);

        return $item;
    }

    /**
     * @var array
     * 分数段配置
     */
    public static $getScoreScale = [
        ['700','750'],
        ['650','700'],
        ['600','650'],
        ['550','600'],
        ['500','550'],
        ['450','500'],
        ['400','450'],
        ['350','400'],
        ['350','0']

    ];
    public static $getSingleScoreScale = [
        ['max' => '150','min' => '140'],
        ['max' => '140','min' =>'130'],
        ['max' => '130','min' =>'120'],
        ['max' => '120','min' =>'110'],
        ['max' => '110','min' =>'100'],
        ['max' => '100','min' =>'90'],
        ['max' => '90','min' =>'80'],
        ['max' => '80','min' =>'70'],
        ['max' => '70','min' =>'60'],
        ['max' => '60','min' =>'50'],
        ['max' => '50','min' =>'40'],
        ['max' => '40','min' =>'0'],

    ];

    public static function getLastTestNum($testNum){
        //本次考试信息
        $currentTestInfo = Test::findOne(['test_num' => $testNum]);
        $lastTest = Test::find()->where(['<','insert_time',$currentTestInfo->insert_time])
            ->andWhere(['grade_num'=>$currentTestInfo->grade_num,'type'=>$currentTestInfo->type])
            ->orderBy('insert_time desc')
            ->asArray()
            ->all();
        if (!$lastTest){
            return false;
        }
        $lastTestInfo = $lastTest[0];
       return $lastTestInfo;
    }

    /**
     * 二维数组根据某个字段排序
     * @param array $array 要排序的数组
     * @param string $keys   要排序的键字段
     * @param string $sort  排序类型  SORT_ASC     SORT_DESC
     * @return array 排序后的数组
     */
    public static function arraySort($array, $keys, $sort = SORT_DESC) {
        $keysValue = [];
        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$keys];
        }
        array_multisort($keysValue, $sort, $array);
        return $array;
    }

    public static function test(){
        return 111;
    }

}