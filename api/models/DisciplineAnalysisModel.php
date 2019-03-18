<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/17
 * Time: 14:05
 */

namespace api\models;


use frontend\models\Class0;
use frontend\models\Score;
use yii\base\Model;

class DisciplineAnalysisModel extends Model
{
    public static function getProfileDataForCourse($testNum,$type){
        //所有班级
        $CourseList = ReadGradeModel::NumConfig($type);
        foreach ($CourseList as &$aitem){
            //年纪均分
            $course = $aitem['value'];
            $gradeAvg = Score::find()->select("avg($course) as avg")
                ->where(['test_num' => $testNum])
                ->asArray()
                ->one();
            //最高分、最低分
            $scoreList = Score::find()->select($course)->where(['test_num' => $testNum])->orderBy("$course desc")->asArray()->all();
            $highest = $scoreList[0][$course];
            $num = count($scoreList);
            $lowest = $scoreList[$num-1][$course];
            //难度系数
            $nandu = (string)(round(($gradeAvg['avg'] / $aitem['maxNum']),'2'));
            //平均分以上
            $avgUp = Score::find()->where(['test_num' => $testNum])
                ->andWhere(['>=',$course,$gradeAvg['avg']])
                ->count();
            //平均分一下
            $avgDown = Score::find()->where(['test_num' => $testNum])
                ->andWhere(['<',$course,$gradeAvg['avg']])
                ->count();
            $aitem['avg'] = $gradeAvg['avg'];
            $aitem['highest'] = $highest;
            $aitem['lowest'] = $lowest;
            $aitem['nandu'] = $nandu;
            $aitem['avgUp'] = $avgUp;
            $aitem['avgUpRatio'] = (string)(round(($avgUp/$num)*100,'2'));
            $aitem['avgDown'] = $avgDown;
            $aitem['avgDownRatio'] = (string)(round(($avgDown/$num)*100,'2'));
        }
        return $CourseList;
    }

    public static function getSingleScaleData($testNum,$course){
        $scaleList = CommonModel::$getSingleScoreScale;
        foreach ($scaleList as &$aitem){
            $num = Score::find()->where(['test_num' => $testNum])
                ->andWhere(['>=',$course,$aitem['min']])
                ->andWhere(['<',$course ,$aitem['max']])
                ->asArray()
                ->count();
            $aitem['num'] = $num;
            $aitem['showName'] = $aitem['max'].'-'.$aitem['min'];
        }

        return $scaleList;
    }
}