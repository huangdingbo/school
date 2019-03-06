<?php

namespace frontend\models;

use common\models\config;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "score".
 *
 * @property int $id
 * @property string $cand_id 考号
 * @property string $student_id 学号
 * @property string $name 姓名
 * @property string $test_name 考试名
 *  @property string $test_num 考试编号
 * @property string $grade 年级
 * @property string $banji 班级
 * @property string $test_room 考场
 * @property string $location 考场位置
 * @property int $seat_num 座位号
 * @property int $chinese 语文
 * @property int $math 数学
 * @property int $english 外语
 * @property int $physics 物理
 * @property int $chemistry 化学
 * @property int $biology 生物
 * @property int $politics 政治
 * @property int $history 历史
 * @property int $geography 地理
 * @property int $total 总分
 * @property int $class_rank 班名
 * @property int $school_rank 校名
 * @property int $type 类型
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Score extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $img;
    public static function tableName()
    {
        return 'score';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cand_id', 'student_id', 'name', 'test_name', 'grade', 'banji', 'test_room', 'location', 'seat_num', 'chinese', 'math', 'english', 'physics', 'chemistry', 'biology', 'politics', 'history', 'geography', 'total', 'class_rank', 'school_rank', 'type'], 'required'],
            [['seat_num', 'chinese', 'math', 'english', 'physics', 'chemistry', 'biology', 'politics', 'history', 'geography', 'total', 'class_rank', 'school_rank', 'type'], 'integer'],
            [['cand_id', 'test_room', 'location', 'insert_time', 'update_time'], 'string', 'max' => 30],
            [['student_id'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 16],
            [['test_name'], 'string', 'max' => 40],
            [['grade'], 'string', 'max' => 8],
            [['banji'], 'string', 'max' => 5],
            [['img'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cand_id' => '考号',
            'student_id' => '学号',
            'name' => '姓名',
            'test_name' => '考试名',
            'test_num' => '考试编号',
            'grade' => '年级',
            'banji' => '班级',
            'test_room' => '考场',
            'location' => '考场位置',
            'seat_num' => '座位号',
            'chinese' => '语文',
            'math' => '数学',
            'english' => '外语',
            'physics' => '物理',
            'chemistry' => '化学',
            'biology' => '生物',
            'politics' => '政治',
            'history' => '历史',
            'geography' => '地理',
            'total' => '总分',
            'class_rank' => '班名',
            'school_rank' => '校名',
            'type' => '类型',
            'img' => '照片',
            'insert_time' => '插入时间',
            'update_time' => '更新时间',
        ];
    }

    public function insertScoreData($list){

        foreach ($list as $key => $item){
            $score = $item == '' ?  0 : $item;
            $arr = explode('_',$key);
            $id = $arr[0];
            $xueke = $arr[1];
            $type = $arr[2];
            (new Query())->createCommand()->update('score',[
                    static::$config[$type][$xueke] => $score
            ],['id'=>$id])->execute();

        }
        return true;
    }

    public static $config = [
        '0' => [
            '1' => 'chinese',
            '2' => 'math',
            '3' => 'english',
            '4' => 'politics',
            '5' => 'history',
            '6' => 'geography',
        ],
        '1' => [
            '1' => 'chinese',
            '2' => 'math',
            '3' => 'english',
            '4' => 'physics',
            '5' => 'chemistry',
            '6' => 'biology',
        ],
    ];

    public function calculateRank($testNum){
        $list = Score::find()->where(['test_num'=>$testNum])->asArray()->all();
        //计算总分
        foreach ($list as $item){
            $total = $item['chinese'] + $item['math'] + $item['english'] + $item['politics'] + $item['history'] + $item['geography'] + $item['physics'] + $item['chemistry'] + $item['biology'];
            (new Query())->createCommand()->update('score',[
                'total' => $total
            ],['id' => $item['id']])->execute();
        }
        //校名
        $schoolRank = Score::find()->where(['test_num'=>$testNum])->orderBy('total desc')->asArray()->all();
//        $oldScoreNum = 1;
//        $countRankNum = 0;
//        $currentRank = 0;
        foreach ($schoolRank as $key => $item){
//            $countRankNum = $key + 1;
//            $currentRank = $key + 1;
//            if ($oldScoreNum == $item['total']){
//                $countRankNum++;
//            }else{
//                $currentRank++;
//            }

            (new Query())->createCommand()->update('score',[
                'school_rank' => ($key+1)
            ],['id' => $item['id']])->execute();

//            $oldScoreNum = $item['total'];
        }
        //班名
        foreach ($list as $item){
            $banji = $item['banji'];
            $classRank = Score::find()->where(['test_num'=>$testNum,'banji'=>$banji])->orderBy('total desc')->asArray()->all();
            foreach($classRank as $k => $value){
                (new Query())->createCommand()->update('score',[
                    'class_rank' => ($k + 1)
                ],['id' => $value['id']])->execute();
            }
        }

        return true;
    }

    public function beforeSave($insert)
    {

       $this->calculateRank($this->test_num);

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
