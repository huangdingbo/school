<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/29
 * Time: 17:34
 */

namespace frontend\models;


use yii\base\Model;

class FileImportForm extends Model
{
    public $uploader;
    public $capt;

    public function rules()
    {
        return [
            ['uploader', 'file', 'extensions' => ['xlsx'], 'maxSize' => 1024 * 1024 * 1024],
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