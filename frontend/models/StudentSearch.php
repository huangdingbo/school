<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Student;

/**
 * StudentSearch represents the model behind the search form of `frontend\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'grade', 'banji', 'duty', 'political_landscape', 'type', 'grade_class'], 'integer'],
            [['student_id', 'test_id', 'name', 'born_time', 'home_address', 'admission_time', 'pic', 'insert_time', 'update_time'], 'safe'],
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
        $query = Student::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 15], //设置分页条数
            'sort' => [
                'defaultOrder' => ['student_id' => 'SORT_DESC'], //排序
//                'attributes' => ['id','title','authorName'], //设置那些字段可以排序
            ],
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
            'grade' => $this->grade,
            'banji' => $this->banji,
            'duty' => $this->duty,
            'political_landscape' => $this->political_landscape,
            'type' => $this->type,
            'grade_class' => $this->grade_class,
        ]);

        $query->andFilterWhere(['like', 'student_id', $this->student_id])
            ->andFilterWhere(['like', 'test_id', $this->test_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'born_time', $this->born_time])
            ->andFilterWhere(['like', 'home_address', $this->home_address])
            ->andFilterWhere(['like', 'admission_time', $this->admission_time])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        return $dataProvider;
    }

    public function dealExportData($models){

        foreach ($models as &$item){
            $item->type = $item->type == 1 ? '理科' : '文科';
            $item->sex = $item->sex == 1 ? '男' : '女';
            $item->grade = $item->grade.'届';
            $item->banji = (Class0::find()->select('name')->where(['id'=>$item->banji])->one())->name;
            $item->duty = (Duty::find()->select('name')->where(['id'=>$item->duty])->one())->name;
            $item->political_landscape = (Political::find()->select('name')->where(['id'=>$item->political_landscape,'type'=>'1'])->one())->name;
            unset($item->grade_class);
            unset($item->insert_time);
            unset($item->update_time);
            unset($item->pic);
        }
        return $models;
    }
}
