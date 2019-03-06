<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kaohao".
 *
 * @property int $id
 * @property string $test_num 考试编号
 * @property string $test_name 考试名字
 * @property string $student_id 学号
 * @property string $cand_num 考号
 * @property string $student_name 学生姓名
 * @property string $class_name 班级名
 * @property string $grade_name 年级名
 * @property string $exam_room 考场
 * @property int $seat_num 座位号
 * @property int $type 类型，1理科，2文科
 * @property string $room_name 考场名
 * @property string $teachers 监考老师
 * @property int $order 排序
 */
class Kaohao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kaohao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seat_num', 'type', 'order'], 'integer'],
            [['room_name', 'teachers', 'order'], 'required'],
            [['test_num', 'student_name', 'room_name'], 'string', 'max' => 20],
            [['test_name', 'cand_num', 'exam_room', 'teachers'], 'string', 'max' => 50],
            [['student_id', 'class_name'], 'string', 'max' => 10],
            [['grade_name'], 'string', 'max' => 6],
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
            'student_id' => '学号',
            'cand_num' => '考号',
            'student_name' => '姓名',
            'class_name' => '班级',
            'grade_name' => '届',
            'exam_room' => '考场',
            'seat_num' => '座位号',
            'type' => '类型',
            'room_name' => '考场名',
            'teachers' => '监考老师',
            'order' => '排序',
        ];
    }
}
