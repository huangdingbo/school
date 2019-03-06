<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/2/26
 * Time: 10:37
 */

namespace frontend\models;


use yii\base\Model;

class TestForm extends Model
{
    public $test_num;
    public $capt;

    public function rules()
    {
        return [
            ['test_num','safe'],
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