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
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class UserController extends MyController
{

    public function actionLogin(){

        $model = new Login();
        if (Yii::$app->request->isGet){
            $data = Yii::$app->request->get();
            if (!$data){
                throw new ForbiddenHttpException('请传参');
            }
            unset($data['r']);
        }
        if (Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if (!$data){
                throw new ForbiddenHttpException('请传参');
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