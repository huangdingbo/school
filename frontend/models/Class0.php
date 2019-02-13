<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "class0".
 *
 * @property int $id
 * @property string $name 班级名
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Class0 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'class0';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
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
            'name' => '班级',
            'insert_time' => '插入时间',
            'update_time' => '最后修改时间',
        ];
    }
}
