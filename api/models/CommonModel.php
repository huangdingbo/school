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
}