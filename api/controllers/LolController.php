<?php
/**
 * Created by PhpStorm.
 * User: 15340
 * Date: 2019/2/9
 * Time: 13:51
 */

namespace api\controllers;


use linslin\yii2\curl\Curl;
use yii\web\Controller;

class LolController extends Controller
{
    public function actionPersion(){
        // 发起post请求,数据为json格式

        $url = 'https://apps.game.qq.com/daoju/v3/api/hx/goods/app/v71/GoodsListApp.php';

        $curl = new Curl();
        $data = $curl
            ->setGetParams([
            'view'=>'biz_cate',
            'page'=>6,
            'pageSize'=>16,
            'orderby'=>'dtShowBegin',
            'ordertype'=>'desc',
            'cate'=>16,
            'appSource'=>'pc',
            'plat'=>1,
            'output_format'=>'json',
            'biz'=>'lol',
            '_'=>'1548770509079',
        ])
        ->get($url);
        var_dump($data);exit;
    }
}