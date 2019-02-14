<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "title".
 *
 * @property int $id
 * @property string $name 职称名
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Title extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'insert_time', 'update_time'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '学历名',
            'insert_time' => '插入时间',
            'update_time' => '最后更新时间',
        ];
    }

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){
            if($insert){
                $this->insert_time = date('Y-m-d H:i:s',time());
                $this->update_time = date('Y-m-d H:i:s',time());
            }else{
                $this->update_time = date('Y-m-d H:i:s',time());
            }
            return true;
        }else{
            return false;
        }
    }
}
