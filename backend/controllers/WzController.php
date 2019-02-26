<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/2/15
 * Time: 11:46
 *
 * 爬取王者荣耀官网英雄数据
 *
 */

namespace backend\controllers;


use QL\QueryList;
use yii\db\Query;
use yii\web\Controller;

class WzController extends Controller
{
    public function actionIndex()
    {
        $list = (new Query)->from('lol')->where(['>=','id','287'])->select('name,pic')->all();
        foreach ($list as $key => $item){
            $qq = rand('1000000000','9999999999');
            (new Query())->createCommand()->insert('teacher',[
                'teacher_id' => ($key+1) < 10 ? '614400'.'0'.($key+1) : '614400'.($key+1),
                'name' => $item['name'],
                'sex' => rand(1,2),
                'born_time' => $this->rand_time('1960-1-1','1990-12-31'),
                'duty' => rand(6,10),
                'diploma' => rand(1,4),
                'political_landscape' => rand(1,6),
                'tel' => '1'.static::$telConfig[rand(0,5)].rand('0','9').rand('0','9').rand('0','9').rand('0','9').rand('0','9').rand('0','9').rand('0','9').rand('0','9').rand('0','9'),
                'qq' => $qq,
                'group' => rand(1,9),
                'email' => $qq.'@qq.com',
                'pic' => $item['pic'],
                'title' => rand(1,4),
                'insert_time' => date('Y-m-d H:i:s',time()),
                'update_time' => date('Y-m-d H:i:s',time()),
            ])->execute();

        }
        echo "<pre>";
        var_dump(111);exit;

    }

    private static $telConfig = [
       '3','4','5','7','8','9'
    ];
    public function rand_time($start_time,$end_time){

        $start_time = strtotime($start_time);

        $end_time = strtotime($end_time);

       return date('Y-m-d', mt_rand($start_time,$end_time));
    }
}