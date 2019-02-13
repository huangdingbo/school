<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "diploma".
 *
 * @property int $id
 * @property string $name 学历名
 * @property string $insert_time 插入时间
 * @property string $update_time 更新时间
 */
class Diploma extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diploma';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'insert_time', 'update_time'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'insert_time' => 'Insert Time',
            'update_time' => 'Update Time',
        ];
    }
}
