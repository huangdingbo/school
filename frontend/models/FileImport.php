<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/29
 * Time: 17:34
 */

namespace frontend\models;


use yii\base\Model;

class FileImport extends Model
{
    public $uploader;
    public $capt;

    public function rules()
    {
        return [
            [['name','email','grade','course'],'safe'],
            ['uploader','file'],
            ['capt','captcha']
        ];
    }

    public function attributeLabels()
    {
        return [
            'uploader'=>'上传文件',
            'capt' => '验证码'
        ];
    }
}