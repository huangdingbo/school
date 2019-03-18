<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/14
 * Time: 16:26
 */

namespace api\controllers;


use api\models\CommonModel;
use api\models\ReadGradeModel;
use frontend\models\Score;
use yii\web\ForbiddenHttpException;

class ReadGradeController extends MyController
{
    /**
     *头部考试筛选
     */
    public function actionHeaderRight(){
        $postData = \Yii::$app->request->post();
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$type){
            throw new ForbiddenHttpException('缺少类型');
        }
        $testList = ReadGradeModel::getTestList($type);
        foreach ($testList as &$aitem){
            $aitem['type'] = $aitem['type'] == 1 ? '理科' : '文科';
            $aitem['name'] =  $aitem['type'] .'-'. $aitem['the'].'届-'.$aitem['test_name'];
        }
        $list = array();
        foreach ($testList as $key => $item){
            $list[$key]['name'] = $item['name'];
            $list[$key]['value'] = $item['test_num'];
        }

        return [
            'list' => $list
        ];
    }

    /**
     *头部类型筛选
     */
    public function actionHeaderLeft(){
        return [
            ['name'=>'理科','value' => '1'],
            ['name'=>'文科','value' => '2'],
        ];
    }
    /**
     * 参考人数
     */
    public function actionNum(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type =  isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型');
        }

        $fidels = ReadGradeModel::NumConfig($type);

        $list = array();

        foreach ($fidels as $key => $fidel){
            $list[$key] = ['name'=>$fidel['name'],'value'=>ReadGradeModel::getPartNum($testNum,$type,$fidel['value'])];
        }
        return $list;
    }

    /**
     *上线情况
     */

    public function actionOnline(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1年级2班级');
        }
        $list = ReadGradeModel::getOnlineData($testNum,$type);

        return $list;
    }

    /**
     * @return array
     * @throws ForbiddenHttpException
     * 年级---学生构成分析
     */
    public function actionConstituteAnalysis(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        $list = array();
        //分数段
        $scoreList = CommonModel::$getScoreScale;
        foreach ($scoreList as $key => &$aitem){
            if ($aitem[1]){
                $aitem['name'] = $aitem[0].'-'.$aitem[1];
                $aitem['value'] = Score::find()->where(['test_num' => $testNum])
                    ->andWhere(['>=','total',$aitem[0]])
                    ->andWhere(['<','total',$aitem[1]])
                    ->asArray()
                    ->count();
            }else{
                $aitem['name'] = $aitem[0].'-';
                $aitem['value'] = Score::find()->where(['test_num' => $testNum])
                    ->andWhere(['<','total',$aitem[0]])
                    ->asArray()
                    ->count();
            }
            $list[$key]['name'] = $aitem['name'];
            $list[$key]['value'] = $aitem['value'];
        }
        return $list;
    }

    /**
     * @param $testNum
     * 年级--成绩显著进步的学生名单
     */
    public function actionProgressStudent(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $size =  isset($postData['size']) ? $postData['size'] : '15';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        //获取上一次考试编号
        $lastTestNum = (CommonModel::getLastTestNum($testNum))['test_num'];
        //本次考试学生排名
        $currentRank = ReadGradeModel::getStudentRankBySchool($testNum);
        $lastRankMap = ReadGradeModel::getStudentRankMap($lastTestNum);

        foreach ($currentRank as &$aitem){
            $lastRank = isset($lastRankMap[$aitem['student_id']]) ? $lastRankMap[$aitem['student_id']] : '0';
            $aitem['showName'] = $aitem['grade'].$aitem['banji'];
            $aitem['changeRank'] = $lastRank - $aitem['school_rank'];
        }
        //排序
        $list = CommonModel::arraySort($currentRank,'changeRank');
        $list = array_slice($list,'0',$size);
        return $list;
    }

    /**
     * @return array
     * @throws ForbiddenHttpException
     * 本次考试-上次考试年级各科均分
     */
    public function actionDivideMore(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }
        //本次考试各科均分
        $currentTestList = ReadGradeModel::getAvgScoreByCourse($testNum,$type);
        //获取上一次考试编号
        $lastTestNum = (CommonModel::getLastTestNum($testNum))['test_num'];
        if ($lastTestNum){
            //上次考试各科均分
            $lastTestList = ReadGradeModel::getAvgScoreByCourse($lastTestNum,$type);
        }else{
            return [
                'currentTestList' => $currentTestList,
                'lastTestList' => false,
            ];
        }

        return [
            'currentTestList' => $currentTestList,
            'lastTestList' => $lastTestList,
        ];
    }

}