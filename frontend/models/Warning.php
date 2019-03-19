<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "warning".
 *
 * @property int $id
 * @property int $score_id 成绩表id
 * @property int $type 类型（1不合格2临界生3学困生4成绩下滑5偏科）
 * @property string $warning_test 预警考试
 * @property string $content 说明
 */
class Warning extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warning';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['score_id', 'type', 'warning_test', 'content'], 'required'],
            [['score_id', 'type'], 'integer'],
            [['warning_test'], 'string', 'max' => 50],
            [['content'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'score_id' => 'Score ID',
            'type' => 'Type',
            'warning_test' => 'Warning Test',
            'content' => 'Content',
        ];
    }
}
