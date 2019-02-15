<?php

namespace frontend\models;

use ciniran\excel\ReadExcel;
use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $student_id 学号
 * @property string $test_id 考号
 * @property string $name 姓名
 * @property int $sex 性别
 * @property string $born_time 出生年月
 * @property string $grade 年级
 * @property int $banji 班级
 * @property int $duty 职务
 * @property string $home_address 家庭住址
 * @property string $admission_time 入学时间
 * @property int $political_landscape 政治面貌
 * @property string $pic 照片
 * @property int $type 类型，0文科，1理科
 * @property int $grade_class 年级班
 * @property string $insert_time 插入时间
 * @property string $update_time 最后更新时间
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['student_id', 'test_id', 'name', 'sex', 'born_time', 'grade', 'banji', 'duty', 'home_address', 'admission_time', 'political_landscape',  'type','pic', 'grade_class', 'insert_time', 'update_time'], 'safe'],
            [['student_id', 'test_id', 'name', 'sex', 'born_time', 'grade', 'banji', 'duty', 'home_address', 'admission_time', 'political_landscape', 'type', 'grade_class', 'insert_time', 'update_time'], 'required'],
            [['sex', 'banji', 'duty', 'political_landscape', 'type', 'grade_class'], 'integer'],
            [['student_id', 'test_id', 'born_time', 'admission_time', 'insert_time', 'update_time'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 10],
            [['grade'], 'string', 'max' => 4],
            [['home_address'], 'string', 'max' => 100],
            [['pic'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => '学号',
            'test_id' => '考号',
            'name' => '姓名',
            'sex' => '性别',
            'born_time' => '出生年月',
            'grade' => '年级',
            'banji' => '班级',
            'duty' => '职务',
            'home_address' => '家庭住址',
            'admission_time' => '入学时间',
            'political_landscape' => '政治面貌',
            'pic' => '照片',
            'type' => '类型',
            'grade_class' => 'Grade Class',
            'insert_time' => '插入时间',
            'update_time' => '最后更新时间',
        ];
    }

    public static function dealPicData(&$data,$filed='Student'){
        if (preg_match('/^http:\/\/ossweb/i',$data[$filed]['pic'])){
            return $data;
        }elseif (!$data[$filed]['pic']){
            $data[$filed]['pic'] = \Yii::$app->params['domain'].Yii::$app->params['defaultImg'];
        }elseif (preg_match('/^http:\/\/huangdingbo.work/i',$data[$filed]['pic'])){
            return $data;
        }elseif (preg_match('/^\/\/game.gtimg.cn/i',$data[$filed]['pic'])){
            return $data;
        }
        else{
            $data[$filed]['pic'] = \Yii::$app->params['domain'].$data[$filed]['pic'];
        }
        return $data;
    }

    public function beforeSave($insert)
    {
        $this->grade_class = $this->grade.'0'.$this->banji;
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

    public function importData($file){
        $path = $file;
        $excel = new ReadExcel([
            'path' => $path,
            'head' => true,
            'headLine' => 1,
            'class' => 'frontend\\models\\Student',
            'useLabel' => true,
        ]);
        $dataModel = $excel->getModels();
        $arr = array();
      foreach ($dataModel as $key =>$item){
          $arr[$key]['Student']['name'] = $item->name;
          $arr[$key]['Student']['student_id'] = $item->student_id;
          $arr[$key]['Student']['test_id'] = $item->test_id;
          $arr[$key]['Student']['sex'] = $item->sex;
          $arr[$key]['Student']['born_time'] = $item->born_time;
          $arr[$key]['Student']['grade'] = $item->grade;
          $arr[$key]['Student']['banji'] = $item->banji;
          $arr[$key]['Student']['duty'] = $item->duty;
          $arr[$key]['Student']['home_address'] = $item->home_address;
          $arr[$key]['Student']['admission_time'] = $item->admission_time;
          $arr[$key]['Student']['political_landscape'] = $item->political_landscape;
          $arr[$key]['Student']['type'] = $item->type;
          $arr[$key]['Student']['pic'] = 'default';
      }

       return $arr;
    }

    public function getGrade0(){
        return $this->hasOne(Grade::className(),['the'=> 'grade']);
    }

    public function getClass0(){
        return $this->hasOne(Class0::className(),['id'=> 'banji']);
    }

    public function getDuty0(){
        return $this->hasOne(Duty::className(),['id'=> 'duty']);
    }

    public function getPolitical0(){
        return $this->hasOne(Political::className(),['id'=> 'political_landscape']);
    }

}
