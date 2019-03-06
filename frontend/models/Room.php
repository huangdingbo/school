<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property string $name 考场名
 * @property string $location 位置
 * @property int $num 人数
 *  @property int $grade 年级
 * @property string $teachers 监考老师
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'location', 'num', 'grade', 'teachers'], 'required'],
            [['num', 'grade'], 'integer'],
            [['name', 'insert_time', 'update_time'], 'string', 'max' => 30],
            [['location'], 'string', 'max' => 20],
//            [['teachers'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '考场名',
            'location' => '位置',
            'num' => '人数',
            'grade' => '届',
            'teachers' => '监考老师',
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
    public function getGrade0(){
        return $this->hasOne(Grade::className(),['id'=> 'grade']);
    }
}
