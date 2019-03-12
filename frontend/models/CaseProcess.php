<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "case_process".
 *
 * @property int $id
 * @property string $case_num 案件编号
 * @property string $process 流程
 * @property string $instructions 说明
 * @property string $pic 图片
 * @property string $date_time 时间
 */
class CaseProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['case_num', 'process', 'instructions', 'date_time'], 'required'],
            [['instructions'], 'string'],
            [['case_num', 'date_time'], 'string', 'max' => 30],
            [['process', 'pic'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'case_num' => 'Case Num',
            'process' => 'Process',
            'instructions' => 'Instructions',
            'pic' => 'Pic',
            'date_time' => 'Date Time',
        ];
    }
}
