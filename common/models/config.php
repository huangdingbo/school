<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/2/25
 * Time: 15:08
 */

namespace common\models;


use frontend\models\Class0;
use frontend\models\Grade;
use frontend\models\Teacher;

class config
{
    public static $courseConfig = [
        '1' => '语文',
        '2' => '数学',
        '3' => '外语',
        '4' => '物理',
        '5' => '化学',
        '6' => '生物',
        '7' => '政治',
        '8' => '历史',
        '9' => '地理',
    ];

    public static $sectionConfig = [
        '1' => '第一节',
        '2' => '第二节',
        '3' => '第三节',
        '4' => '第四节',
        '5' => '第五节',
        '6' => '第六节',
        '7' => '第七节',
    ];

    public static function getLocationMap(){
        $grade = Grade::find()->select('the')->asArray()->all();
        $banji = Class0::find()->select('name')->asArray()->all();
        $arr = array();
        foreach ($grade as $item){
            $gradeName = $item['the'].'届';
            foreach ($banji as $value){
                $name = $gradeName.$value['name'];
                $arr[$name] = $name;
            }
        }
        return $arr;
    }

    public static function getData($indexBy = 'teacher_id'){
        $data = Teacher::find()
            ->select('name,group,teacher_id')
            ->orderBy('group asc')
            ->asArray()
            ->all();
        return  self::dealData($data,$indexBy);
    }

    private static function dealData($data,$indexBy){
        $arr = array();
        foreach($data as $item){
            $arr[$item[$indexBy]] = config::$courseConfig[$item['group']].'-'.$item['name'];
        }

        return $arr;
    }

    public static function dump($data){
        echo "<pre>";
        var_dump($data);exit;
    }

    public static $caseType = [
        '1' => '打架斗殴',
        '2' => '抽烟',
        '3' => '酗酒',
        '4' => '逃课',
        '5' => '上网',
        '6' => '迟到',
        '7' => '携带手机',
        '8' => '上课睡觉',
    ];

    public static $caseStatus = [
        '1' => '处理中',
        '2' => '已解决',
    ];

}