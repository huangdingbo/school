<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Cases;

/**
 * CasesSearch represents the model behind the search form of `frontend\models\Cases`.
 */
class CasesSearch extends Cases
{
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(),['selectedType']);
    }
    public function rules()
    {
        return [
            [['id', 'type', 'status'], 'integer'],
            [['case_num', 'title', 'description', 'pic', 'create_id', 'point_id','selectedType'], 'safe'],
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
        $pointId = \Yii::$app->user->id;
        $createId = \Yii::$app->user->id;
        $query = Cases::find()->where(['or',"point_id = $pointId","create_id = $createId"])->orderBy('status asc');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 15], //设置分页条数
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
            'type' => $this->type,
            'status' => $this->status,
        ]);


        $query->andFilterWhere(['like', 'case_num', $this->case_num])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'create_id', $this->create_id])
            ->andFilterWhere(['like', 'point_id', $this->point_id]);

        if ($this->selectedType == 1){
            $query->andFilterWhere(['create_id' => \Yii::$app->user->id]);
        }

        if ($this->selectedType == 2){
            $query->andFilterWhere(['!=','create_id',\Yii::$app->user->id])
                    ->andFilterWhere(['point_id' => \Yii::$app->user->id]);
        }


        return $dataProvider;
    }
}
