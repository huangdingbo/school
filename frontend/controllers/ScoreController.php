<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/1/29
 * Time: 21:39
 */

namespace frontend\controllers;


use yii\web\Controller;

class ScoreController extends Controller
{
    public function actionEntry(){

        return $this->render('entry');
    }
}