<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/7
 * Time: 21:34
 */

namespace api\controllers;


use api\models\CommonModel;
use frontend\models\Score;
use frontend\models\Student;
use frontend\models\Teacher;
use frontend\models\Test;

class CockpitController extends MyController
{
    //校园概况
    public function actionSchoolSituation(){
        $studentNum = Student::find()->count();
        $teacherNum = Teacher::find()->count();
        $gradeOne = Student::find()->where(['grade' => '2017'])->count();
        $gradeTwo = Student::find()->where(['grade' => '2018'])->count();
        $gradeThree = Student::find()->where(['grade' => '2019'])->count();

        return [
            'studentNum' => $studentNum,
            'teacherNum' => $teacherNum,
            'gradeOne' => $gradeOne,
            'gradeTwo' => $gradeTwo,
            'gradeThree' => $gradeThree,
        ];
    }

    //教职工分布
    public function actionTeacherDistribution(){
        $list = Teacher::find()->leftJoin('title','teacher.title = title.id')
            ->select('count(*) as value,title.name as name')
            ->groupBy('teacher.title ')
            ->orderBy('title.id desc')
            ->asArray()
            ->all();
        return [
            'list' => $list
        ];
    }

    //龙虎榜
    public function actionRankPic(){
        //最新考试
        $newTest = CommonModel::getNewTest();
        //列表
        $list = Score::find()->leftJoin('student','student.student_id = score.student_id')
            ->select('score.name,score.grade,score.banji,score.total,score.school_rank,student.pic')
            ->where(['test_num' => '20191551929393'])
            ->orderBy('score.school_rank asc')
            ->limit(20)
            ->asArray()
            ->all();
        return [
            'list' => $list
        ];
    }

    public function actionRegularMap(){
        $newTest = CommonModel::getNewTest();
        $regularWire = '425';
        $list = Score::find()
            ->where(['test_num' => '20191551929393'])
            ->andFilterWhere(['>=','total',$regularWire])
            ->select('count(*) as value,banji as name')
            ->groupBy('banji')
            ->orderBy('value desc')
            ->asArray()
            ->all();
        $totalNum =  Score::find()
            ->where(['test_num' => '20191551929393'])
            ->andFilterWhere(['>','total',$regularWire])
            ->count();
        foreach ($list as &$aitem){
            $aitem['ratio'] = (string)(round(($aitem['value'] / $totalNum)*100,'2')) ;
        }

       return [
           'list' => $list
       ];
    }

    public function actionWeighDistribution(){
        $newTest = CommonModel::getNewTest();
        $weightWire = '500';
        $list = Score::find()
            ->where(['test_num' => '20191551929393'])
            ->andFilterWhere(['>=','total',$weightWire])
            ->select('count(*) as value,banji as name')
            ->groupBy('banji')
            ->orderBy('value desc')
            ->asArray()
            ->all();
        $totalNum =  Score::find()
            ->where(['test_num' => '20191551929393'])
            ->andFilterWhere(['>','total',$weightWire])
            ->count();
        foreach ($list as &$aitem){
            $aitem['ratio'] = (string)(round(($aitem['value'] / $totalNum)*100,'2')) ;
        }
        return [
            'list' => $list
        ];
    }

    public function actionYearWire(){
        $start = date('Y',time()).'-01-01 00:00:00';
        $end = date('Y',time()).'-12-31 23:59:59';

        $list = Score::find()->where(['total'])
            ->andFilterWhere(['<=','insert_time',$end])
            ->andFilterWhere(['>=','insert_time',$start]);
    }

    public function actionWheel(){
        
    }
}