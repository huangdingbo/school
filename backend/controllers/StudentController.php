<?php
/**
 * Created by PhpStorm.
 * Login: 黄定波
 * Date: 2019/2/11
 * Time: 18:07
 *
 *
 * 添加学生表假数据
 *
 */
namespace backend\controllers;
use yii\db\Query;
use yii\web\Controller;

class StudentController extends Controller
{
    public function actionTest(){

       for ($i=0;$i<3;$i++){
           $offset1 = $i*50;
           for ($j=0;$j<5;$j++){
               $offset = $offset1 + $j*10;
               $list = (new Query())->from('lol')
                   ->limit('10')
                   ->offset($offset)
                   ->select('*')
                   ->all();
               $query =  (new Query())->from('lol')
                   ->limit('10')
                   ->offset($offset)
                   ->select('*')
                   ->createCommand()
                   ->getRawSql();
               var_dump($query) ;
               echo "<br>";
               $k = 1;
               foreach($list as $item){
                    (new Query())->createCommand()->insert(
                       'student',[
                           'student_id' => self::$config['id'][$i].'0'.($j+1).'0'.$k,
                           'test_id' => self::$config['id'][$i].'0'.($j+1).'0'.$k,
                           'name' => $item['name2'],
                           'sex' => rand(1,2),
                           'born_time' => date('Y-m-d',time()),
                           'grade' => self::$config['id'][$i],
                           'banji' => $j+1,
                           'duty' => rand(1,5),
                           'home_address' => self::$config['home_address'][rand(0,23)],
                           'admission_time' => self::$config['id'][$i].'-09-01',
                           'political_landscape' => rand(1,2),
                           'pic' => $item['pic'],
                           'type' => 1,
                           'grade_class' => self::$config['id'][$i].'0'.($j+1),
                           'insert_time' => date('Y-m-d H:i:s',time()),
                           'update_time' => date('Y-m-d H:i:s',time()),
                   ]
                   )->execute();
                   $k++;
               }
           }
       }
       echo 'ok';exit;
    }
    private static $config = [
        'id'=>[
            0 => '2017',
            1 => '2018',
            2 => '2019',
        ],
        'home_address'=>[
            '电一艾欧尼亚',
            '电二祖安',
            '电三诺克萨斯',
            '电四班德尔城',
            '电五皮尔特沃夫',
            '电六战争学院',
            '电七巨神峰',
            '电八雷瑟守备',
            '电九裁决之地',
            '电十黑色玫瑰',
            '电十一暗影岛',
            '电十二钢铁烈阳',
            '电十三均衡教派',
            '电十四水晶之痕',
            '电十五影流',
            '电十六守望之海',
            '电十七征服之海',
            '电十八卡拉曼达',
            '网一比尔吉沃特',
            '网二德玛西亚',
            '网三弗雷尔卓德',
            '网四无畏先锋',
            '网五恕瑞玛',
            '网六扭曲丛林',
        ],
    ];
    public function actionIndex(){
        echo 111;
    }
}