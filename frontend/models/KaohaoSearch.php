<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Kaohao;

/**
 * KaohaoSearch represents the model behind the search form of `frontend\models\Kaohao`.
 */
class KaohaoSearch extends Kaohao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'seat_num', 'type', 'order'], 'integer'],
            [['test_num', 'test_name', 'student_id', 'cand_num', 'student_name', 'class_name', 'grade_name', 'exam_room', 'room_name', 'teachers'], 'safe'],
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
        $query = Kaohao::find();

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
            'seat_num' => $this->seat_num,
            'type' => $this->type,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'test_num', $this->test_num])
            ->andFilterWhere(['like', 'test_name', $this->test_name])
            ->andFilterWhere(['like', 'student_id', $this->student_id])
            ->andFilterWhere(['like', 'cand_num', $this->cand_num])
            ->andFilterWhere(['like', 'student_name', $this->student_name])
            ->andFilterWhere(['like', 'class_name', $this->class_name])
            ->andFilterWhere(['like', 'grade_name', $this->grade_name])
            ->andFilterWhere(['like', 'exam_room', $this->exam_room])
            ->andFilterWhere(['like', 'room_name', $this->room_name])
            ->andFilterWhere(['like', 'teachers', $this->teachers]);

        return $dataProvider;
    }

    public function dealExportData($models){
        foreach ($models as &$item){
            $item->type = $item->type == 1 ? '理科' : '文科';
            $list = json_decode($item->teachers);
            if (is_array($list)){
                $count = count($list);
                $str = '';
                for ($i=0;$i<$count;$i++){
                    if ($i == ($count-1)){
                        $str .= $list[$i];
                    }else{
                        $str .= $list[$i].',';
                    }
                }
                $item->teachers = $str;
            }
        }
       return $models;
    }
}
