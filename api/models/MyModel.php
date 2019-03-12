<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/6
 * Time: 14:19
 */

namespace api\models;


use yii\db\Query;

class MyModel
{
    /**
     * @return $this
     */
    public static function make($table){

        $obj = (new Query()) -> from($table);

        return $obj;
    }
}