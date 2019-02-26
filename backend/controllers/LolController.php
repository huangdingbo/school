<?php
/**
 * Created by PhpStorm.
 * User: 15340
 * Date: 2019/2/9
 * Time: 13:51
 */

namespace backend\controllers;

use linslin\yii2\curl\Curl;
use yii\db\Query;
use yii\web\Controller;

class LolController extends Controller
{
    public function actionPersion(){
        // 发起post请求,数据为json格式

        for ($i=1;$i<=9;$i++){

            $url = 'https://apps.game.qq.com/daoju/v3/api/hx/goods/app/v71/GoodsListApp.php';
            $curl = new Curl();
            $data = $curl
                ->setGetParams([
                'view'=>'biz_cate',
                'page'=>$i,
                'pageSize'=>16,
                'orderby'=>'dtShowBegin',
                'ordertype'=>'desc',
                'cate'=>16,
                'appSource'=>'pc',
                'plat'=>'1',
                'output_format'=>'json',
                'biz'=>'lol',
                '_'=>'1548770509079',
            ])
            ->get($url);

            $res = json_decode($data);
            echo '<pre>';
            foreach ($res->data->goods as $item){
                    $name = $item->propName;
                    $pic = $v=$item->propImg;
                    $nickname = explode(' ',$name);
                    (new Query())->createCommand()->insert('lol',[
                        'name'=>$name,
                        'pic'=>$pic,
                        'name1'=>$nickname[0],
                        'name2'=>$nickname[1],
                    ])->execute();

            }

        }
        echo 111;
    }
}