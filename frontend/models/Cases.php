<?php

namespace frontend\models;

use common\models\SameModel;
use Yii;

/**
 * This is the model class for table "cases".
 *
 * @property int $id
 * @property string $case_num 案件编号
 * @property int $type 案件类型（1打架斗殴2抽烟3酗酒4顶撞老师5逃课6上网7携带手机8上课睡觉）
 * @property string $title 标题
 * @property string $description 描述
 * @property string $pic 图片
 * @property string $old_point_id 上一次指派人ID
 * @property string $create_id 创建人ID
 * @property string $point_id 指派人ID
 * @property string $insert_time 插入时间
 * @property int $status 1处理中2已解决3可激活
 */
class Cases extends \yii\db\ActiveRecord
{
    public $process;
    public $instr;
    public $instrPic;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['case_num', 'type', 'title', 'description', 'create_id', 'point_id'], 'required'],
            [['type', 'status'], 'integer'],
            [['description','instr'], 'string'],
            [['case_num'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 50],
            [['pic'], 'string', 'max' => 100],
            [['create_id', 'point_id','old_point_id','insert_time'], 'string', 'max' => 30],
            [['instrPic','instr','process'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'case_num' => '事件编号',
            'type' => '事件类型',
            'title' => '标题',
            'description' => '描述',
            'pic' => '图片',
            'create_id' => '创建人ID',
            'point_id' => '指派人ID',
            'status' => '状态',
            'instr' => '说明',
            'instrPic' => '说明图片（可不上传）',
            'insert_time' => '插入时间'

        ];
    }

    public function addOtherInfo(){
        if (!empty($this->pic)){
            $this->pic = Yii::$app->params['domain'].$this->pic;
        }
        $userId = Yii::$app->user->id;
        $nickName = (Adminuser::findOne(['id' => $userId]))->nickname;
        $this->case_num = (string)time();
        $this->create_id = (string)(Yii::$app->user->id);
        $this->point_id = (string)(Yii::$app->user->id);
        $this->old_point_id = (string)(Yii::$app->user->id);
        $this->status = '1';
        if (!$this->save()){
            return false;
        }
        $processModel = new CaseProcess();
        $processModel->case_num = $this->case_num;
        $processModel->process = '事件由'."<b>".$nickName."</b>".'创建';
        $processModel->instructions = $this->description;
        $processModel->pic = $this->pic;
        $processModel->date_time = date('Y-m-d H:i:s',time());
        if (!$processModel->save()){
            return false;
        }
        return true;
    }

    public function  addProcess($oldPointId){
        if (!empty($this->instrPic)){
            $this->instrPic = Yii::$app->params['domain'].$this->instrPic;
        }
        $processModel = new CaseProcess();
        $processModel->case_num = $this->case_num;
        $processModel->process = '由'."<b>".(SameModel::getAdminuser($oldPointId))->nickname."</b>".'指派给'."<b>".(SameModel::getAdminuser($this->point_id))->nickname."</b>";
        $processModel->date_time = date('Y-m-d H:i:s',time());
        $processModel->instructions = $this->instr;
        $processModel->pic = $this->instrPic;
        if (!$processModel->save()){
            return false;
        }
        return true;
    }

    public function addSolveProcess(){
        if (!empty($this->instrPic)){
            $this->instrPic = Yii::$app->params['domain'].$this->instrPic;
        }
        $processModel = new CaseProcess();
        $processModel->case_num = $this->case_num;
        $processModel->process = '事件由'."<b>".(SameModel::getAdminuser($this->point_id))->nickname."</b>".'解决';
        $processModel->date_time = date('Y-m-d H:i:s',time());
        $processModel->instructions = $this->instr;
        $processModel->pic = $this->instrPic;
        if (!$processModel->save()){
            return false;
        }
        $this->point_id = $this->create_id;
        $this->save();
        return true;
    }

    public function addSolveActivation(){
        if (!empty($this->instrPic)){
            $this->instrPic = Yii::$app->params['domain'].$this->instrPic;
        }
        $processModel = new CaseProcess();
        $processModel->case_num = $this->case_num;
        $processModel->process = '事件由'."<b>".(SameModel::getAdminuser($this->create_id))->nickname."</b>".'激活';
        $processModel->date_time = date('Y-m-d H:i:s',time());
        $processModel->instructions = $this->instr;
        $processModel->pic = $this->instrPic;
        if (!$processModel->save()){
            return false;
        }

        return true;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($insert){
                $this->insert_time = date('Y-m-d H:i:s',time());
            }
            return true;
        }else{
            return false;
        }
    }
}
