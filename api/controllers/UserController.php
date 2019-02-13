<?php
/**
 * Created by PhpStorm.
 * Login: huang
 * Date: 2019/2/12
 * Time: 11:19
 */

namespace api\controllers;


use api\models\Login;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionLogin(){
        header('Access-Control-Allow-Origin:*');

        header('Access-Control-Allow-Methods:GET,POST,PATCH,PUT,OPTIONS');


        $model = new Login();
        if (Yii::$app->request->isGet){
            $data = Yii::$app->request->get();
            if (!$data){
                die('请传参');
            }
            unset($data['r']);
        }
        if (Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if (!$data){
                die('请传参');
            }
        }
        $model->load($data);
        if ( !$model->check()) {
           return [
               'isPass' => false,
               'userName' => '',
           ];
        }
        return [
            'list' => [
                'isPass' => true,
                'userName' => $model->getUser(),
            ],
        ];
    }
}