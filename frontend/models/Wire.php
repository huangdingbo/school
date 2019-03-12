<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "wire".
 *
 * @property int $id
 * @property string $test_num 考试编号
 * @property int $benke_wire 本科线
 * @property int $zhongben_wire 重本线
 * @property int $benke_num 本科上线人数
 * @property int $zhongben_num 重本上线人数
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Wire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wire';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_num', 'benke_wire', 'zhongben_wire', 'benke_num', 'zhongben_num', 'insert_time', 'update_time'], 'required'],
            [['benke_wire', 'zhongben_wire', 'benke_num', 'zhongben_num'], 'integer'],
            [['test_num', 'insert_time', 'update_time'], 'string', 'max' => 30],
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
            'benke_wire' => '本科线',
            'zhongben_wire' => '重本线',
            'benke_num' => '本科上线数',
            'zhongben_num' => '重本上线数',
            'insert_time' => '插入时间',
            'update_time' => '更新时间',
        ];
    }

    public function getOnlineNum($test_num,$wire){
        $num = Score::find()->where(['test_num' => $test_num])
            ->andWhere(['>=','total',$wire])
            ->count();

        return $num;
    }
}
