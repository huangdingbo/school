<?php

namespace frontend\models;

use common\models\config;
use Yii;

/**
 * This is the model class for table "grade_class".
 *
 * @property int $id
 * @property int $grade 年级
 * @property int $banji 班级
 * @property int $status 状态,1已排，0未排
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class GradeClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade', 'banji'], 'required'],
            [['grade', 'banji', 'status'], 'integer'],
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
            'grade' => '届',
            'banji' => '班级',
            'status' => '状态',
            'insert_time' => '插入时间',
            'update_time' => '最后更新时间',
        ];
    }

    public function getGrade0(){

        return $this->hasOne(Grade::className(),['id'=>'grade']);
    }

    public function getClass0(){
        return $this->hasOne(Class0::className(),['id'=>'banji']);
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

    public function getData(){
        $data = Teacher::find()
            ->select('name,group,teacher_id')
            ->orderBy('group asc')
            ->asArray()
            ->all();
       return  $this->dealData($data);
    }

    private function dealData($data){
       $arr = array();
        foreach($data as $item){
            $arr[$item['teacher_id']] = config::$courseConfig[$item['group']].'-'.$item['name'];
        }

        return $arr;
    }

    public function getValue($info){
        $list = Course::find()->where(['grade'=>$info->grade,'banji'=>$info->banji])->asArray()->all();
        $arr = array();
        foreach ($list as $item){
            $k = $item['week_num'].$item['section_num'];
            $arr[$k] = $item['teacher_id'];
        }
       return $arr;
    }

    public function getCourseTable($info){
        $grade = $info->grade;
        $banji = $info->banji;
        $data = Course::find()->leftJoin('teacher','teacher.teacher_id=course.teacher_id')
            ->select('teacher.name,teacher.group,course.week_num,course.section_num')
            ->where(['course.grade'=>$grade,'course.banji'=>$banji])
            ->asArray()
            ->all();
        $arr = array();
        foreach ($data as $item){
            $k = $item['week_num'].$item['section_num'];
            $arr[$k] = config::$courseConfig[$item['group']].'('.$item['name'].')';
        }
       return $arr;
    }

    public function getExportData($info){

        $list = $this->getCourseTable($info);
        $arr = array();
        for ($i=1;$i<8;$i++){
            for ($j=0;$j<8;$j++){
                if ($j == 0){
                    $jie = \common\models\config::$sectionConfig[$i];
                    $arr[$i-1][$j] = $jie;
                }else{
                    $key = $j.$i;
                    $arr[$i-1][$j] =  isset($list[$key]) ? $list[$key] : '';
                }
            }
        }
      return $arr;
    }
}
