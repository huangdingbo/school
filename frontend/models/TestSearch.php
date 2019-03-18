<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Test;

/**
 * TestSearch represents the model behind the search form of `frontend\aa\Test`.
 */
class TestSearch extends Test
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'grade_num', 'status', 'type'], 'integer'],
            [['test_num', 'test_name', 'insert_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Test::find()->orderBy('status asc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10], //设置分页条数
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'grade_num' => $this->grade_num,
            'status' => $this->status,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'test_num', $this->test_num])
            ->andFilterWhere(['like', 'test_name', $this->test_name])
            ->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        return $dataProvider;
    }
}
