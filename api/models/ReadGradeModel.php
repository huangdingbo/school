<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/14
 * Time: 16:53
 */

namespace api\models;


use frontend\models\Class0;
use frontend\models\Score;
use frontend\models\Test;
use yii\base\Model;

class ReadGradeModel extends Model
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     * 获取考试列表
     */
    public static function getTestList($type){
        $query = Test::find()->leftJoin('grade','grade.id = test.grade_num')
            ->select('test.test_name,test.test_num,grade.the,type')
            ->where(['test.status'=>'2'])
            ->orderBy('test.test_num desc,test.insert_time desc')
            ->asArray();
        if ($type){
            $query->andWhere(['type' => $type]);
        }
        return $query -> all();
    }

    /**
     * @param $testNum
     * @param $type
     * @param $fidel
     * @return int|string
     * 获取各科参考人数
     */
    public static function getPartNum($testNum,$type,$fidel){
        $num = Score::find()->where(['type' => $type,'test_num' => $testNum])
            ->andWhere(['!=',$fidel,'0'])
            ->count();
        return $num;
    }

    /**
     * @param $type
     * @return array
     * 根据类型配置筛选字段
     */
    public static function NumConfig($type){
        return [
            ['name' => '语文','value'=>'chinese','maxNum'=>'150'],
            ['name' => '数学','value'=>'math','maxNum'=>'150'],
            ['name' => '外语','value'=>'english','maxNum'=>'150'],
            ['name' =>  $type==1 ? '物理' : '政治','value'=> $type==1 ? 'physics' : 'politics','maxNum'=>'120'],
            ['name' =>  $type==1 ? '化学' : '历史','value'=> $type==1 ? 'chemistry' : 'history','maxNum'=>'90'],
            ['name' =>  $type==1 ? '生物' : '地理','value'=>  $type==1 ? 'biology' : 'geography','maxNum'=>'80'],
        ];
    }

    /**
     * @param $testNum
     * @param $type
     * @return array
     * 班级、年级的上线情况
     */
    public static function getOnlineData($testNum,$type){
        $wireModel = CommonModel::getTestWire($testNum);
        $totalNum = CockpitModel::getTestStudentNum($testNum);
        if ($type == 1){
            $zhongBenNum = $wireModel->zhongben_num;
            $zhongbenRadio = (string)(round(($zhongBenNum / $totalNum)*100,'2')) ;
            $benkeNum = $wireModel->benke_num;
            $benkeRadio = (string)(round(($benkeNum / $totalNum)*100,'2'));
            $offline =  $totalNum - $zhongBenNum - $benkeNum;
            $offlineRadio = (string)(round(($offline / $totalNum)*100,'2'));
            return [
                'zhongBenNum' => $zhongBenNum,
                'zhongbenRadio' => $zhongbenRadio,
                'benkeNum' => $benkeNum,
                'benkeRadio' => $benkeRadio,
                'offline' => $offline,
                'offlineRadio' => $offlineRadio,
            ];
        }else{
            //所有班级
            $classList = Class0::find()->select('name as banji')
                ->orderBy('id asc')
                ->asArray()
                ->all();
            $list = array();
            foreach ($classList as &$aitem){
                $list[] = array_merge(static::getClassOnline($testNum,$aitem['banji']),$aitem);
            }
            return $list;
        }

    }

    /**
     * @param $testNum
     * @param $class
     * @return array
     * 一个考试每个班的上线情况
     */
    public static function getClassOnline($testNum,$class){
        $wire = CommonModel::getTestWire($testNum);
        $totalNum = CockpitModel::getTestStudentNum($testNum);
        $zhongbenNum = Score::find()->where(['test_num' => $testNum,'banji' => $class])
            ->andWhere(['>=','total',$wire->zhongben_wire])
            ->count();
        $zhongbenRadio = (string)(round(($zhongbenNum / $totalNum)*100,'2')) ;
        $benkeNum = Score::find()->where(['test_num' => $testNum,'banji' => $class])
            ->andWhere(['>=','total',$wire->benke_wire])
            ->count();
        $benkeRadio = (string)(round(($benkeNum / $totalNum)*100,'2')) ;
        $offline = $totalNum - $zhongbenNum - $benkeNum;
        $offlineRadio = (string)(round(($offline / $totalNum)*100,'2')) ;
        return [
            'zhongBenNum' => $zhongbenNum,
            'zhongbenRadio' => $zhongbenRadio,
            'benkeNum' => $benkeNum,
            'benkeRadio' => $benkeRadio,
            'offline' => $offline,
            'offlineRadio' => $offlineRadio,
        ];
    }

    /**
     * @param $testNum
     * @return array
     * 获取学生--校名Map
     */
    public static function getStudentRankMap($testNum){
        $list = Score::find()->where(['test_num' => $testNum])
            ->select('school_rank as rank,student_id as id')
            ->indexBy('id')
            ->asArray()
            ->column();
       return $list;
    }

    /**
     * @param $testNum
     * @return array|\yii\db\ActiveRecord[]
     * 获取学生校名排名
     */
    public static function getStudentRankBySchool($testNum){
        $list = Score::find()->where(['test_num' => $testNum])
            ->select('	student_id,name,grade,banji,total,school_rank')
            ->orderBy('total desc')
            ->asArray()
            ->all();

        return $list;
    }

    /**
     * @param $testNum
     * @param $type
     * 获取考试各科均分
     */
    public static function getAvgScoreByCourse($testNum,$type){

        $courseList = self::NumConfig($type);

        foreach ($courseList as &$aitem){
            $aitem['avg'] = ReadGradeModel::getGradeSingleAvgCourse($testNum,$aitem['value'],$type);
        }
       return $courseList;
    }

    /**
     * @param $testNum
     * @param $filed
     * @param $type
     * @return string
     * 获取考试各科均分
     */
    public static function getGradeSingleAvgCourse($testNum,$filed,$type){
        $list = Score::find()->where(['test_num'=>$testNum])
            ->select([$filed])
            ->asArray()
            ->all();
        $num = 0;
        foreach ($list as $item){
            $num += $item[$filed];
        }
        //参考人数
        $studentNum = self::getPartNum($testNum,$type,$filed);

        return (string)(round(($num / $studentNum),'2')) ;
    }


}