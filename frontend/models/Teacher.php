<?php

namespace frontend\models;

use ciniran\excel\ReadExcel;
use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property int $id
 * @property string $teacher_id 教师编号
 * @property string $name 姓名
 * @property int $sex 性别
 * @property int $group 所在分组（1语2数3外4物5化6生7政8史9地）
 * @property string $born_time 出生年月
 * @property int $duty 职务
 * @property int $diploma 学历
 * @property int $political_landscape 政治面貌
 * @property string $tel 电话
 * @property string $qq qq
 * @property string $email 邮箱
 * @property string $pic 照片
 * @property int $title 职称
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'name', 'sex', 'born_time','duty', 'diploma', 'political_landscape', 'tel', 'qq', 'email', 'title','group', 'insert_time', 'update_time'], 'required'],
            [['sex', 'duty', 'diploma', 'political_landscape', 'title','group'], 'integer'],
            [['teacher_id', 'name', 'born_time', 'insert_time', 'update_time'], 'string', 'max' => 20],
            [['tel', 'qq'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 50],
            [['pic'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => '教师编号',
            'name' => '姓名',
            'sex' => '性别',
            'born_time' => '出生日期',
            'duty' => '职务',
            'diploma' => '学历',
            'political_landscape' => '政治面貌',
            'group' => '所在分组',
            'tel' => '电话',
            'qq' => 'QQ',
            'email' => '邮箱',
            'pic' => '照片',
            'title' => '职称',
            'insert_time' => '插入时间',
            'update_time' => '更新时间',
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
    //导入教师信息
    public function importData($file){
        $path = $file;
        $excel = new ReadExcel([
            'path' => $path,
            'head' => true,
            'headLine' => 1,
            'class' => 'frontend\\models\\Teacher',
            'useLabel' => true,
        ]);
        $dataModel = $excel->getModels();

        $arr = array();
        foreach ($dataModel as $key =>$item){
            $arr[$key]['Teacher']['name'] = $item->name;
            $arr[$key]['Teacher']['teacher_id'] = $item->teacher_id;
            $arr[$key]['Teacher']['sex'] = $item->sex;
            $arr[$key]['Teacher']['born_time'] = $item->born_time;
            $arr[$key]['Teacher']['duty'] = $item->duty;
            $arr[$key]['Teacher']['diploma'] = $item->diploma;
            $arr[$key]['Teacher']['tel'] = $item->tel;
            $arr[$key]['Teacher']['political_landscape'] = $item->political_landscape;
            $arr[$key]['Teacher']['group'] = $item->group;
            $arr[$key]['Teacher']['qq'] = $item->qq;
            $arr[$key]['Teacher']['pic'] = Yii::$app->params['domain'].Yii::$app->params['defaultImg'];
            $arr[$key]['Teacher']['email'] = $item->email;
            $arr[$key]['Teacher']['title'] = $item->title;
        }

        return $arr;
    }

    public function getDuty0(){
        return $this->hasOne(Duty::className(),['id'=> 'duty']);
    }

    public function getPolitical0(){
        return $this->hasOne(Political::className(),['id'=> 'political_landscape']);
    }

    public function getDiploma0(){
        return $this->hasOne(Diploma::className(),['id'=> 'diploma']);
    }

    public function getTitle0(){
        return $this->hasOne(Title::className(),['id'=> 'title']);
    }
}
