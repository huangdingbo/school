<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/28
 * Time: 14:14
 */

namespace api\controllers;


use api\models\MyModel;
use yii\web\Controller;

class TestController extends MyController
{

    public function actionIndex(){

      $list = MyModel::make('student')->select('*')->all();

      return [
          'list' => $list,
          'csrf' => \Yii::$app->request->csrfToken
      ];
    }

}