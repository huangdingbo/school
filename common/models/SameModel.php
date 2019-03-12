<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/11
 * Time: 11:44
 */

namespace common\models;


use frontend\models\Adminuser;
use yii\base\Model;

class SameModel extends Model
{
    public static function getAdminuser($id){
        return Adminuser::findOne(['id' => $id]);
    }
}