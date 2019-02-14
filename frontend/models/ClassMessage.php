<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "class_message".
 *
 * @property int $id
 * @property string $name 班级名
 * @property string $grade 年级
 * @property string $managers 班主任
 * @property int $alias 别名（1火箭班2飞机班3普通班）
 * @property string $slogan 口号
 * @property string $leadership 分管领导
 * @property int $num 人数
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class ClassMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'class_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'grade', 'managers', 'alias', 'slogan', 'leadership', 'num'], 'required'],
            [['alias', 'num'], 'integer'],
            [['name', 'managers', 'leadership'], 'string', 'max' => 20],
            [['grade'], 'string', 'max' => 4],
            [['slogan'], 'string', 'max' => 100],
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
            'name' => '班级名',
            'grade' => '年级名',
            'managers' => '班主任',
            'alias' => '别名',
            'slogan' => '口号',
            'leadership' => '分管领导',
            'num' => '人数',
            'insert_time' => '插入时间',
            'update_time' => '最后更新时间',
        ];
    }

    public function getGrade0(){
        return $this->hasOne(Grade::className(),['the'=> 'grade']);
    }

    public function getManager0(){
        return $this->hasOne(Teacher::className(),['teacher_id'=>'managers']);
    }

    public function getClass0(){
        return $this->hasOne(Class0::className(),['id'=> 'name']);
    }

    public function beforeSave($insert)
    {
        $this->num = Student::find()
            ->where(['banji'=>$this->name,'grade'=>$this->grade])
            ->count();
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
