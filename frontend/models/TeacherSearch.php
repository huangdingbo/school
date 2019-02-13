<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Teacher;

/**
 * TeacherSearch represents the model behind the search form of `frontend\models\Teacher`.
 */
class TeacherSearch extends Teacher
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'banji', 'duty', 'diploma', 'political_landscape', 'title'], 'integer'],
            [['teacher_id', 'name', 'born_time', 'grade', 'tel', 'qq', 'email', 'pic', 'grade_calss', 'insert_time', 'update_time'], 'safe'],
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
        $query = Teacher::find();

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
            'sex' => $this->sex,
            'banji' => $this->banji,
            'duty' => $this->duty,
            'diploma' => $this->diploma,
            'political_landscape' => $this->political_landscape,
            'title' => $this->title,
        ]);

        $query->andFilterWhere(['like', 'teacher_id', $this->teacher_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'born_time', $this->born_time])
            ->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'grade_calss', $this->grade_calss])
            ->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        return $dataProvider;
    }
}
