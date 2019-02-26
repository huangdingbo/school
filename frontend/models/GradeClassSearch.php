<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\GradeClass;

/**
 * GradeClassSearch represents the model behind the search form of `frontend\models\GradeClass`.
 */
class GradeClassSearch extends GradeClass
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'grade', 'banji','status'], 'integer'],
            [['insert_time', 'update_time'], 'safe'],
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
        $query = GradeClass::find();

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
            'grade' => $this->grade,
            'banji' => $this->banji,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        return $dataProvider;
    }
}
