<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/7
 * Time: 21:34
 */

namespace api\controllers;


use api\models\CockpitModel;
use api\models\CommonModel;
use frontend\models\Score;
use frontend\models\Student;
use frontend\models\Teacher;
use frontend\models\Test;
use frontend\models\Wire;

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
            ->where(['test_num' => $newTest['test_num']])
            ->orderBy('score.school_rank asc')
            ->limit(20)
            ->asArray()
            ->all();
        return [
            'list' => $list
        ];
    }
    //本次考试各班本科概况
    public function actionRegularMap(){
        $newTest = CommonModel::getNewTest();
        $regularWire = (Wire::findOne(['test_num' => $newTest['test_num']]))->benke_wire;
        $list = Score::find()
            ->where(['test_num' => $newTest['test_num']])
            ->andFilterWhere(['>=','total',$regularWire])
            ->select('count(*) as value,banji as name')
            ->groupBy('banji')
            ->orderBy('value desc')
            ->asArray()
            ->all();
        $totalNum =  Score::find()
            ->where(['test_num' => $newTest['test_num']])
            ->andFilterWhere(['>','total',$regularWire])
            ->count();
        foreach ($list as &$aitem){
            $aitem['ratio'] = (string)(round(($aitem['value'] / $totalNum)*100,'2')) ;
        }

       return [
           'list' => $list
       ];
    }
    //本次考试重本分布
    public function actionWeighDistribution(){
        $newTest = CommonModel::getNewTest();
        $weightWire = (Wire::findOne(['test_num' => $newTest['test_num']]))->zhongben_wire;
        $list = Score::find()
            ->where(['test_num' => $newTest['test_num']])
            ->andFilterWhere(['>=','total',$weightWire])
            ->select('count(*) as value,banji as name')
            ->groupBy('banji')
            ->orderBy('value desc')
            ->asArray()
            ->all();
        $totalNum =  Score::find()
            ->where(['test_num' => $newTest['test_num']])
            ->andFilterWhere(['>','total',$weightWire])
            ->count();
        foreach ($list as &$aitem){
            $aitem['ratio'] = (string)(round(($aitem['value'] / $totalNum)*100,'2')) ;
        }
        return [
            'list' => $list
        ];
    }
    //年度本科上线率
    public function actionYearWire(){
        $list['three'] =  CockpitModel::getYearRatio(CockpitModel::GRADE_ONE,CockpitModel::STUDENT_LIKE);
        $list['two'] =  CockpitModel::getYearRatio(CockpitModel::GRADE_TWO,CockpitModel::STUDENT_LIKE);
        $list['one'] =  CockpitModel::getYearRatio(CockpitModel::GRADE_THREE,CockpitModel::STUDENT_LIKE);

        return [
            'list' => $list
        ];
    }
    //底部轮子
    public function actionWheel(){
        //最新考试
        $newTest = CommonModel::getNewTest();
        $model = Wire::findOne(['test_num' => $newTest['test_num']]);
        //本科上线人数
        $benkeNum = $model->benke_num;
        //重本上线人数
        $zhongbenNum = $model->zhongben_num;
        //本次考试总人数
        $totalNum = CockpitModel::getTestStudentNum($newTest['test_num']);
        //本科上线率
        $benkeRatio = (string)(round(($benkeNum / $totalNum)*100,'0')) ;
        //重本占比
        $zhongbenRatio = (string)(round(($zhongbenNum / $benkeNum)*100,'0')) ;

        return [
            'benkeRatio' => $benkeRatio,
            'zhongbenRatio' => $zhongbenRatio,
        ];
    }

    /**
     *校园案件概况
     */
    public function actionCaseOverview(){
        //案件总量
        $caseTotal = CockpitModel::getCaseTotalNum();
        //日均案件量
        $caseAvg = CockpitModel::getCaseAvgDayNum();
        //受理率
        $acceptRatio = CockpitModel::getAcceptRatio();
        return [
            'caseTotal' => $caseTotal,
            'caseAvg' => $caseAvg,
            'acceptRatio' => $acceptRatio,
        ];
    }

    /**
     * 事件高发类型TOP6
     */
    public function actionHighCase(){
        $list = CockpitModel::getCaseHighType();
        return [
            'list' => $list
        ];
    }
}