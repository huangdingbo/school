<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lol".
 *
 * @property int $id
 * @property string $name 名字
 * @property string $pic 图片
 * @property string $name1 称号
 * @property string $name2 名字
 * @property string $content
 */
class Lol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['pic'], 'string', 'max' => 500],
            [['name1', 'name2'], 'string', 'max' => 50],
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
            'pic' => 'Pic',
            'name1' => 'Name1',
            'name2' => 'Name2',
            'content' => 'Content',
        ];
    }
}
