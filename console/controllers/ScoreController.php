<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/6
 * Time: 18:00
 */
namespace console\controllers;

use frontend\models\Kaohao;
use frontend\models\Score;
use frontend\models\Test;
use yii\console\Controller;
use yii\db\Query;
use linslin\yii2\curl;

class ScoreController extends Controller
{
    public function actionMake(){
        //查有没有正在进行的考试
        $test = Test::findOne(['status' => '1']);
        $testNum = $test->test_num;
        if (!$test){
            echo "\n";
            echo date('Y-m-d H:i:s',time()).'-'.$testNum.'-'.'没有正在进行的考试';exit;
        }
        $kaohao = Kaohao::findOne(['test_num' => $testNum]);
        if (!$kaohao){
            echo "\n";
            echo date('Y-m-d H:i:s',time()).'-'.$testNum.'-'.'没有生成考号';exit;
        }
        //查成绩表有没有本次考试
        if (Score::findOne(['test_num' => $testNum])){
            //有就全部查出来
            $list = Score::find()->where(['test_num' => $testNum])->asArray()->all();
            foreach ($list as &$aitem){
                $score = array();
                $score['chinese'] = rand(70,150);
                $score['math'] = rand(30,150);
                $score['english'] = rand(30,150);
                if($test->type == 1){
                    $score['physics'] = rand(30,120);
                    $score['chemistry'] = rand(10,90);
                    $score['biology'] = rand(10,80);
                }else{
                    $score['politics'] = rand(10,100);
                    $score['history'] = rand(10,100);
                    $score['geography'] = rand(10,100);
                }
                (new Query())->createCommand()->update('score',$score,['id' => $aitem['id']])->execute();
            }

             $curl = new curl\Curl();
            $curl -> setGetParams([
                'id' => $test->id,
                'test_num' => $testNum,
                'r' => 'score/create'
            ])->get('http://huangdingbo.work/school/frontend/web/index.php');

            $test->status = 2;
            $test->save();
            echo "\n";
            echo date('Y-m-d H:i:s',time()).'-'.$testNum.'-考试'.'成绩录入成功';exit;
        }else{
            echo "\n";
            echo date('Y-m-d H:i:s',time()).'-'.'成绩表没有'.$testNum.'考试';exit;
        }
    }
}