<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\web\ForbiddenHttpException;

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
    public $benkeWire;
    public $benkeNum;
    public $zhongbenWire;
    public $zhongbenNum;
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
        if(parent::beforeSave($insert)){
            if($insert){
                $this->test_num = (Grade::find()->where(['id'=>$this->grade_num])->one())->the.time();
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

    public function getCandData($test_info,$is_rand = 1){
        if ($is_rand == 1){
            $test_num = $test_info->test_num;
            $test_name = $test_info->test_name;
            $grade = (Grade::find()->where(['id'=>$test_info->grade_num])->one())->the;
            $studentList = Student::find()->select('student_id,test_id,name,grade,banji')
                ->where(['grade'=>$grade,'type'=>$test_info->type])
                ->orderBy('RAND()')
                ->asArray()
                ->all();
            foreach ($studentList as $i=>$item){
                $studentList[$i]['test_num'] = $test_num;
                $studentList[$i]['test_name'] = $test_name;
                $studentList[$i]['grade'] = $item['grade'].'届';
                $studentList[$i]['banji'] = (Class0::find()->where(['id'=>$item['banji']])->one())->name;
                $studentList[$i]['type'] = $test_info->type;
            }
            //排考试座位
            $roomInfo = Room::find()->where(['grade'=>$test_info->grade_num])->asArray()->all();
            $count = 0;
            $studentNum = count($studentList);

            $sum = 0;
            foreach ($roomInfo as $s){
                $sum += $s['num'];
            }
            if ($sum < $studentNum){
                return false;
            }
            foreach ($roomInfo as $item){

                $num = $item['num'];
                for ($i=0;$i<$num;$i++){

                    if ($count>=$studentNum){
                        break;
                    }
                    $studentList[$count]['room_name'] = $item['name'];
                    $studentList[$count]['teachers'] = $item['teachers'];
                    $studentList[$count]['seat_num'] = $i+1;
                    $studentList[$count]['exam_room'] = $item['location'];
                    $studentList[$count]['order'] = $count;
                    $count++;
                }
            }

        }

        return $studentList;

    }

    public function insertCandData($list,$testNum){
        foreach ($list as $item){
            $result = (new Query())->createCommand()->insert('kaohao',[
                'student_id' => $item['student_id'],
                'test_num' => $testNum,
                'test_name' => $item['test_name'],
                'cand_num' => $item['test_id'],
                'student_name' => $item['name'],
                'class_name' => $item['banji'],
                'grade_name' => $item['grade'],
                'exam_room' => $item['exam_room'],
                'room_name' => $item['room_name'],
                'teachers' => $item['teachers'],
                'seat_num' => $item['seat_num'],
                'type' => $item['type'],
                'order' => $item['order']
            ])->execute();
            if (!$result){
                throw new ForbiddenHttpException('操作失败');
            }
        }
        return true;
    }
    public function dealKaohao($kaohaoList,$testInfo){
        foreach ($kaohaoList as &$item){
            $item['test_num'] = $testInfo->test_num;
            $item['test_name'] = $testInfo->test_name;
            $item['test_id'] = $item['cand_id'];
        }

        //排考试座位
        $roomInfo = Room::find()->where(['grade'=>$testInfo->grade_num])->asArray()->all();

        $count = 0;
        $studentNum = count($kaohaoList);

        $sum = 0;
        foreach ($roomInfo as $s){
            $sum += $s['num'];
        }
        if ($sum < $studentNum || $roomInfo == null){
            return false;
        }
        foreach ($roomInfo as $sitem){

            $num = $sitem['num'];
            for ($i=0;$i<$num;$i++){

                if ($count>=$studentNum){
                    break;
                }
                $kaohaoList[$count]['room_name'] = $sitem['name'];
                $kaohaoList[$count]['teachers'] = $sitem['teachers'];
                $kaohaoList[$count]['seat_num'] = $i+1;
                $kaohaoList[$count]['exam_room'] = $sitem['location'];
                $kaohaoList[$count]['order'] = $count;
                $count++;
            }
        }

        return $kaohaoList;
    }

    public function getWire0(){
        return $this->hasOne(Wire::className(),['test_num'=> 'test_num']);
    }

}
