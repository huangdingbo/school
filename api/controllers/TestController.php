<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/28
 * Time: 14:14
 */

namespace api\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(){
        \Yii::$app->response->format = 'json';
        $list = array(
            'result' => 'ok',
            'time' => time(),
        );

        return [
            'list' => $list
        ];
    }

}