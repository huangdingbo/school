<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "political".
 *
 * @property int $id
 * @property string $name 政治面貌名
 * @property int $type 1学生2老师
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Political extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'political';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['insert_time', 'update_time'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '政治面貌',
            'type' => '类型',
            'insert_time' => '插入时间',
            'update_time' => '最后修改时间',
        ];
    }

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){
            if($insert){
                $type = Yii::$app->request->get();
                $this->type = $type['type'];
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
