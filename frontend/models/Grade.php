<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property int $id
 * @property string $the 届
 * @property string $name 年级名
 * @property string $insert_time 插入时间
 * @property string $updata_time 更新时间
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['the'], 'required'],
            [['the'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 10],
            [['insert_time', 'updata_time'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '年级',
            'the' => '届',
            'insert_time' => '插入时间',
            'updata_time' => '最后修改时间',
        ];
    }

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){
            if($insert){
                $this->insert_time = date('Y-m-d H:i:s',time());
                $this->updata_time = date('Y-m-d H:i:s',time());
            }else{
                $this->updata_time = date('Y-m-d H:i:s',time());
            }
            return true;
        }else{
            return false;
        }
    }
}
