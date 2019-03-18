<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/18
 * Time: 12:09
 */

namespace backend\controllers;



use api\models\ReadGradeModel;
use frontend\models\Score;
use frontend\models\Test;
use frontend\models\Warning;
use frontend\models\Wire;
use yii\db\Query;
use yii\web\Controller;

class WarningController extends Controller{
    public function actionRun(){
        //已经划线的考试
        $wireTest = Wire::find()->where(['!=','benke_wire', ''])
            ->andWhere(['!=','zhongben_wire',''])
            ->asArray()
            ->all();
        foreach ($wireTest as $test){
            //如果预警表有本次考试的预警，就进行下一次循环
            if (Warning::findOne(['warning_test' => $test['test_num']])){
                continue;
            }
            //否则，拿到考试编号去成绩表进行预警
            //本次考试信息
            $currentTestInfo = $this->getTestInfo($test['test_num']);
            //上次考试信息
            $lastTestList =  Test::find()->where(['<','insert_time',$currentTestInfo['insert_time']])
                ->andWhere(['grade_num' => $currentTestInfo['grade_num'],'type' => $currentTestInfo['type']])
                ->orderBy('insert_time desc')
                ->asArray()
                ->one();
            //本次考试成绩列表
            $scoreList = Score::find()->where(['test_num'=>$test['test_num']])->orderBy('insert_time asc')->asArray()->all();
            foreach ($scoreList as $item){
                //检查是否合格
                if ($item['total'] <= ($test['benke_wire'] - 30)){ //不合格
                    $warningInfo = [
                        'score_id' => $item['id'],
                        'type' => '1',
                        'warning_test' => $item['test_num'],
                        'content' => $this->getContent('1',($test['benke_wire']-$item['total'])),
                        'status' => '1',
                    ];
                    $this->insertWarningData($warningInfo);
                }else{ //检查是否上次考试预警，解除预警
                    $lastWarningInfo = Warning::find()->leftJoin('score','warning.score_id = score.id')
                        ->select('warning.id')
                        ->where(['score.student_id'=>$item['student_id'],'warning_test' => $lastTestList['test_num'],'warning.type' => '1'])
                        ->asArray()
                        ->one();
                    if ($lastWarningInfo){
                        $this->updataWarningData($lastWarningInfo['id']);
                    }
                }
                //检查是否临界生
                $onlineOrofflineScore = $item['total'] - $test['benke_wire'];
                $judge = $onlineOrofflineScore >= 0 ? $onlineOrofflineScore : -$onlineOrofflineScore;
                if ($judge <= 10){
                    $warningInfo = [
                        'score_id' => $item['id'],
                        'type' => '2',
                        'warning_test' => $item['test_num'],
                        'content' => $this->getContent('2',($onlineOrofflineScore)),
                        'status' => '1',
                    ];
                    $this->insertWarningData($warningInfo);
                }else{ //检查是否上次考试预警，解除预警
                    $lastWarningInfo = Warning::find()->leftJoin('score','warning.score_id = score.id')
                        ->select('warning.id')
                        ->where(['score.student_id'=>$item['student_id'],'warning_test' => $lastTestList['test_num'],'warning.type' => '2'])
                        ->asArray()
                        ->one();
                    if ($lastWarningInfo){
                        $this->updataWarningData($lastWarningInfo['id']);
                    }
                }
                //检查是否学困生
                if ($item['total'] <= '300'){ //学困
                    $warningInfo = [
                        'score_id' => $item['id'],
                        'type' => '3',
                        'warning_test' => $item['test_num'],
                        'content' => $this->getContent('3',($item['total'] - 300)),
                        'status' => '1',
                    ];
                    $this->insertWarningData($warningInfo);
                }else{ //检查是否上次考试预警，解除预警
                    $lastWarningInfo = Warning::find()->leftJoin('score','warning.score_id = score.id')
                        ->select('warning.id')
                        ->where(['score.student_id'=>$item['student_id'],'warning_test' => $lastTestList['test_num'],'warning.type' => '3'])
                        ->asArray()
                        ->one();
                    if ($lastWarningInfo){
                        $this->updataWarningData($lastWarningInfo['id']);
                    }
                }
                //检查成绩下滑
                $lastTestRank = Score::find()->select('school_rank')
                    ->where(['test_num' => $lastTestList['test_num'],'student_id' => $item['student_id']])
                    ->asArray()
                    ->one();
                $lastTestRank = isset($lastTestRank['school_rank']) ? $lastTestRank['school_rank'] : 0;
                $diffRank = $item['school_rank'] - $lastTestRank;
                if ($diffRank < -20){
                    $warningInfo = [
                        'score_id' => $item['id'],
                        'type' => '4',
                        'warning_test' => $item['test_num'],
                        'content' => $this->getContent('4',(-$diffRank)),
                        'status' => '1',
                    ];
                    $this->insertWarningData($warningInfo);
                }else{
                    $lastWarningInfo = Warning::find()->leftJoin('score','warning.score_id = score.id')
                        ->select('warning.id')
                        ->where(['score.student_id'=>$item['student_id'],'warning_test' => $lastTestList['test_num'],'warning.type' => '4'])
                        ->asArray()
                        ->one();
                    if ($lastWarningInfo){
                        $this->updataWarningData($lastWarningInfo['id']);
                    }
                }

                //偏科
                //总成绩平均分
                $totalAvg = $this->getTotalAvg($test['test_num'],$item['type']);
                if ($item['total'] >= $totalAvg){
                    $singleCourseList = ReadGradeModel::getAvgScoreByCourse($test['test_num'],$item['type']);
                   foreach ($singleCourseList as  $single){
                       //语文
                       if ($item[$single['value']] < $single['avg']){
                           $warningInfo = [
                               'score_id' => $item['id'],
                               'type' => '5',
                               'warning_test' => $item['test_num'],
                               'content' => $this->getContent('5',($single['avg'] - $item[$single['value']]),$single['name']),
                               'dine' => $single['name'],
                               'status' => '1',
                           ];
                           $this->insertWarningData($warningInfo);
                       }else{
                           $lastWarningInfo = Warning::find()->leftJoin('score','warning.score_id = score.id')
                               ->select('warning.id')
                               ->where(['score.student_id'=>$item['student_id'],'warning_test' => $lastTestList['test_num'],'warning.type' => '5','dine' => $single['name']])
                               ->asArray()
                               ->one();
                           if ($lastWarningInfo){
                               $this->updataWarningData($lastWarningInfo['id']);
                           }
                       }

                    }
                }
            }
        }
        return 111;
    }

    private static $config = [
        '0' => '不合格学生',
        '1' => '临界生',
        '2' => '学困生',
        '3' => '偏科学生',
    ];

    private function  getTestInfo($testNum){
        return Test::find()->where(['test_num'=>$testNum])->asArray()->one();
    }

    /**
     * @param $type
     * @param int $num
     * 获取预警说明
     */
    private function getContent($type,$num = 0,$course = ''){
        $content =  [
                '1' => "成绩不合格，低于本科线{$num}分",
                '2' => $num > 0 ? "临界本科线上{$num}分" : "临界本科线下{$num} 分",
                '3' => "学困生，低于300分{$num}分",
                '4' => "总成绩排名下滑，排名下降{$num}名",
                '5' => "{$course}偏科，在平均分下{$num}分"
            ];
        return $content[$type];
    }

    private function insertWarningData($info = []){
        return  ((new Query())->createCommand()->insert('warning',$info)->execute());
    }

    private function updataWarningData($id){
        return ((new Query())->createCommand()->update('warning',['status' => '2'],['id' => $id])->execute());
    }

    private function getTotalAvg($testNum,$type){
        $scoreList = Score::find()->select('total')
            ->where(['test_num' => $testNum,'type' => $type])
            ->asArray()
            ->all();
        $num = count($scoreList);
        $total = 0;
        foreach ($scoreList as $item){
            $total += $item['total'];
        }

        return (string)round($total / $num,'0');
    }
}