<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/7
 * Time: 23:47
 */

namespace frontend\controllers;


use frontend\models\User;
use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(){
        $model = new User();
        $model->username = 'admin';
//        $pass = \Yii::$app->security->generatePasswordHash('123');
//        var_dump($pass);exit;
        $model->password_hash = \Yii::$app->security->generatePasswordHash('123');
        $model->auth_key = '123';
        $model->email = 'admin@qq.com';
        $model->created_at = time();
        $model->updated_at = time();
        $model->status = 10;
        $model->save();
        echo 1;
    }
    public function actionSession(){
        echo "<pre>";
        var_dump($user = \Yii::$app->user->identity->username);
    }
}