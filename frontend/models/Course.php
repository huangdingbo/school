<?php

namespace frontend\models;

use common\models\config;
use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string $course_id 课程编号
 * @property int $grade 年级
 * @property int $banji 班级
 * @property string $course_name 课程中文
 * @property string $teacher_id 教师
 * @property string $week_num 节数
 * @property int $section_num 节数
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'grade', 'banji', 'course_name', 'teacher_id', 'week_num', 'section_num'], 'required'],
            [['grade', 'banji', 'section_num'], 'integer'],
            [['course_id'], 'string', 'max' => 8],
            [['course_name'], 'string', 'max' => 4],
            [['teacher_id', 'insert_time', 'update_time'], 'string', 'max' => 20],
            [['week_num'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'grade' => 'Grade',
            'banji' => 'Banji',
            'course_name' => 'Course Name',
            'teacher_id' => 'Teacher ID',
            'week_num' => 'Week Num',
            'section_num' => 'Section Num',
            'insert_time' => 'Insert Time',
            'update_time' => 'Update Time',
        ];
    }

    public function getData($id,$key,$grade,$banji){
        if ($id){
            $list = Teacher::find()
                ->select('group')
                ->where(['teacher_id'=>$id])
                ->one();
        }
        $week_section = explode('_',$key);
        $arr = array();
        $arr['Course'] = [
            'course_name'=>$id ? config::$courseConfig[$list->group] : '',
            'grade' => $grade,
            'banji' => $banji,
            'week_num' => $week_section[0],
            'section_num' => $week_section[1],
            'teacher_id' => $id ? $id : '',
            'course_id' => $id ? (Grade::find()->select('the')->where(['id'=>$grade])->one())->the.'0'.$banji.'0'.$list->group : '',
        ];
        return $arr;
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
