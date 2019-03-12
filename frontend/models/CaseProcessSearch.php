<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\CaseProcess;

/**
 * CaseProcessSearch represents the model behind the search form of `frontend\models\CaseProcess`.
 */
class CaseProcessSearch extends CaseProcess
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['case_num', 'process', 'instructions', 'pic', 'date_time'], 'safe'],
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
        $query = CaseProcess::find();

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
        ]);

        $query->andFilterWhere(['like', 'case_num', $this->case_num])
            ->andFilterWhere(['like', 'process', $this->process])
            ->andFilterWhere(['like', 'instructions', $this->instructions])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'date_time', $this->date_time]);

        return $dataProvider;
    }
}
