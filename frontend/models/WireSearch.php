<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Wire;

/**
 * WireSearch represents the model behind the search form of `frontend\models\Wire`.
 */
class WireSearch extends Wire
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'benke_wire', 'zhongben_wire', 'benke_num', 'zhongben_num'], 'integer'],
            [['test_num', 'insert_time', 'update_time'], 'safe'],
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
        $query = Wire::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'benke_wire' => $this->benke_wire,
            'zhongben_wire' => $this->zhongben_wire,
            'benke_num' => $this->benke_num,
            'zhongben_num' => $this->zhongben_num,
        ]);

        $query->andFilterWhere(['like', 'test_num', $this->test_num])
            ->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        return $dataProvider;
    }
}
