<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/18
 * Time: 19:08
 */

namespace api\models;


use frontend\models\Class0;
use frontend\models\Grade;
use frontend\models\Score;
use frontend\models\Student;
use frontend\models\Test;
use frontend\models\Warning;
use frontend\models\Wire;
use yii\base\Model;

class WarningIndexModel extends  Model
{
    public static function getWarningNum($testNum,$type,$studentType,$grade,$class){
        $query = Warning::find()->leftJoin('score','score.id = warning.score_id')
            ->where(['score.type' => $studentType,'score.grade' => $grade]);
        if ($type){
            $query -> andWhere(['warning.type' => $type]);
        }
        $newQuery = clone $query;
        if ($testNum){
            $query -> andWhere(['warning.warning_test' => $testNum]);
        }

        if ($class){
            $query -> andWhere(['score.banji' => $class]);
        }
        //当前预警
        $currentNum = $query->andWhere(['warning.status' => 1])->count();
        //预警总数
        $totalNum = $newQuery->count();
        //预警/次
        if (!$testNum){
            $kaoshiNum = Test::find()->where(['type'=>$studentType,'grade_num' => self::$config[$grade]])->count();
            $avg = (string)round($totalNum/$kaoshiNum,'0');
        }
        return [
            'currentNum' => $currentNum,
            'totalNum' => $totalNum,
            'avg' => isset($avg) ? $avg : '',
        ];
    }

    private static $config = [
        '2019届' => '1',
        '2018届' => '2',
        '2017届' => '3',
    ];

    public static function getGradeList(){
        $list = Grade::find()->select('the as name')->orderBy('id asc')->asArray()->all();
        foreach ($list as &$aitem){
            $aitem['value'] = $aitem['name'].'届';
            $aitem['name'] = $aitem['value'];
        }

        return $list;
    }

    public static function getClassList(){
        $list = Class0::find()->select('name')->orderBy('id asc')->asArray()->all();
        foreach ($list as &$aitem){
            $aitem['value'] = $aitem['name'];
        }

        return $list;
    }

    public static function getHighRiskStudent($grade,$type){
        $testNum = Test::find()->where(['grade_num' => $grade,'type' => $type])->count();
        preg_match('/\d+/',$grade,$arr);
        $studentList = Student::find()->where(['type'=>$type])
            ->andWhere(['grade'=>$arr[0]])
            ->asArray()
            ->all();
        $list = array();
        foreach ($studentList as $item){
            $num = Score::find()->leftJoin('warning','score.id = warning.score_id')
                ->where(['score.student_id' => $item['student_id']])
                ->count();
            if ($num >= $testNum){
                $banji = (Class0::findOne(['id'=>$item['banji']]))->name;
                $list[] = [
                    'name' => $item['name'],
                    'studentId' => $item['student_id'],
                    'gradeAndClass' => $item['grade'].'届'.$banji,
                    'warningNum' => $num,
                ];
            }
        }
        return $list;
    }

    public static function getWarningTypeData($grade,$type){

        $list = Score::find()->leftJoin('warning','score.id = warning.score_id')
            ->select('count(*) as value,warning.type as name')
            ->where(['score.grade' => $grade,'score.type' => $type])
            ->groupBy('warning.type')
//            ->createCommand()->getRawSql();
            ->asArray()
            ->all();
        $sum = 0;
        foreach ($list as $key=>&$item){
            if (!$item['name']){
                unset($list[$key]);
                continue;
            }
            $sum += $item['value'];
            $item['name'] = self::$warningType[$item['name']];
        }

        foreach ($list as &$item){
            $item['ratio'] = (string)(round(($item['value']/$sum)*100,'2'));
        }
        return array_values($list);

    }
    public static $warningType = [
        '1' => '成绩不合格学生',
        '2' => '临界学生',
        '3' => '学困学生',
        '4' => '成绩下滑学生',
        '5' => '偏科学生',
    ];

    public static function getWarningWorkList(){
        $newTest = CommonModel::getNewTest();
        $list = Warning::find()->leftJoin('test','test.test_num = warning.warning_test')
            ->select('warning.id,warning.content as value,test.test_name as name')
            ->where(['warning.warning_test' => $newTest['test_num']])
            ->asArray()->all();
        return $list;
    }

    public static function getWarningDevelopList($grade,$class,$type,$studentType){
        $query = Warning::find()->leftJoin('score','score.id = warning.score_id')
            ->where(['score.grade' => $grade,'score.type' => $studentType]);
        if ($class){
            $query->andWhere(['score.banji' => $class]);
        }
        if ($type){
            $query->andWhere(['warning.type' => $type]);
        }
        $list = $query->select('count(*) as value,score.test_name as name')
            ->groupBy('score.test_name')
            ->orderBy('score.insert_time asc')
            ->limit(10)
            ->asArray()
            ->all();
       return $list;
    }

    public static function getWarningStatisticalList($grade,$class,$type,$studentType,$test){
        $query = Warning::find()->leftJoin('score','score.id = warning.score_id')
            ->select('warning.id,score.name,score.grade,score.banji,warning.content,warning.status')
            ->where(['score.grade' => $grade,'score.type' => $studentType,'warning.type' => $type]);
        if ($class){
           $query->andWhere(['score.banji' => $class]);
        }
        if ($test){
            $query->where(['score.test_num' => $test]);
        }

        $list = $query->orderBy('score.insert_time desc')->asArray()->all();

        foreach ($list as &$item){
            $item['status'] = $item['status'] == 1 ? '正在预警' : '预警已解除';
            $item['show'] = $item['grade'].$item['banji'];
        }
        return $list;
    }

    public static function getWarningAllList($grade,$class,$test,$type,$studentType,$course,$status,$nameStr){
        $query = Warning::find()->leftJoin('score','score.id = warning.score_id');
        if ($grade){
            $query->andWhere(['score.grade' => $grade]);
        }
        if ($class){
            $query->andWhere(['score.banji' => $class]);
        }
        if ($test){
            $query->andWhere(['score.test_num' => $test]);
        }
        if ($type){
            $query->andWhere(['warning.type' => $type]);
        }
        if ($studentType){
            $query->andWhere(['score.type' => $studentType]);
        }
        if ($course){
            $query->andWhere(['warning.dine' => $course]);
        }
        if ($status){
            $query->andWhere(['warning.status' => $status]);
        }
        if ($nameStr){
            $query->andWhere(['like','score.name',$nameStr]);
        }
        if ($course){
            $selectStr = 'score.test_name,score.grade,score.banji,score.name,score.type as studentType,warning.type,warning.content,warning.dine,warning.status';
        }else{
            $selectStr = 'score.test_name,score.grade,score.banji,score.name,score.type as studentType,warning.type,warning.content,warning.status';
        }
        $list = $query->select($selectStr)
            ->orderBy('score.insert_time desc')
            ->asArray()
            ->all();
        foreach ($list as &$item){
            $item['studentType'] = $item['studentType'] == 1 ? '理科' : '文科';
            $item['type'] = self::$warningType[$item['type']];
            $item['status'] = $item['status'] == 1 ? '正在预警' : '预警已解除';
        }
       return $list;
    }

    public static function getWarningDetail($id){
        $warningInfo = Warning::find()->where(['id' => $id])->asArray()->one();
        $scoreInfo = Score::find()->where(['id' => $warningInfo['score_id']]) -> asArray() -> one();

        $warningInfo['type'] = self::$warningType[$warningInfo['type']];
        $warningInfo['status'] = $warningInfo['status'] == 1 ? '正在预警' : '预警已解除';
        $scoreInfo['type'] = $scoreInfo['type'] == 1 ? "理科" : '文科';
        return [
            'warningInfo' => $warningInfo,
            'scoreInfo' => $scoreInfo,
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     * 获取考试列表
     */
    public static function getTestList($type,$grade){
        preg_match('/\d+/',$grade,$arr);
        $query = Test::find()->leftJoin('grade','grade.id = test.grade_num')
            ->select('test.test_name,test.test_num,grade.the,type')
            ->where(['test.status'=>'2','grade.the' => $arr[0]])
            ->orderBy('test.test_num desc,test.insert_time desc')
            ->asArray();
        if ($type){
            $query->andWhere(['type' => $type]);
        }
        return $query->asArray()->all();
    }
}