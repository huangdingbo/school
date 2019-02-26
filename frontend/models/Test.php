<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string $test_num 考试编号
 * @property string $test_name 考试名称
 * @property int $grade_num 年级编号
 * @property int $status 状态,1正在进行，2结束
 * @property int $type 类型，1理科，2文科
 * @property string $insert_time 插入时间
 * @property string $update_time 插入时间
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade_num', 'status', 'type'], 'integer'],
            [['test_num'], 'string', 'max' => 20],
            [['test_name'], 'string', 'max' => 50],
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
            'test_num' => '考试编号',
            'test_name' => '考试名',
            'grade_num' => '届',
            'status' => '状态',
            'type' => '类型',
            'insert_time' => '插入时间',
            'update_time' => '最后更新时间',
        ];
    }

    public function getGrade0(){
        return $this->hasOne(Grade::className(),['id'=> 'grade_num']);
    }

    public function beforeSave($insert)
    {
        $this->test_num = (Grade::find()->where(['id'=>$this->grade_num])->one())->the.time();
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
