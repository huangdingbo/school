<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/2/15
 * Time: 11:15
 */

namespace api\controllers;


use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class MyController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true
                ],
            ],
        ], parent::behaviors());
    }
}