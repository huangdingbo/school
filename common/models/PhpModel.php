<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/8
 * Time: 16:41
 */

namespace common\models;


use yii\base\Model;

class PhpModel extends Model
{

    //获取一个文件夹里的文件个数
    public static function getFileCounts($dir){
        $handle = opendir($dir);
        $i = 0;
        while(false !== $file=(readdir($handle))){
            if($file !== '.' && $file != '..')
            {
                $i++;
            }
        }
        closedir($handle);
        return $i;
    }
}