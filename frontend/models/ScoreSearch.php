<?php

namespace frontend\models;

use common\models\config;
use QL\Dom\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Score;

/**
 * ScoreSearch represents the model behind the search form of `frontend\models\Score`.
 */
class ScoreSearch extends Score
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'seat_num', 'chinese', 'math', 'english', 'physics', 'chemistry', 'biology', 'politics', 'history', 'geography', 'total', 'class_rank', 'school_rank', 'type'], 'integer'],
            [['cand_id', 'student_id', 'name', 'test_name', 'test_num', 'grade', 'banji', 'test_room', 'location', 'insert_time', 'update_time'], 'safe'],
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
        $query = Score::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 15], //设置分页条数
            'sort' => [
                'defaultOrder' => ['total' => 'SORT_DESC'], //排序
//                'attributes' => ['id','title','authorName'], //设置那些字段可以排序
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //默认理科
        if ($this->type == ''){
            $this->type = 1;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'chinese' => $this->chinese,
            'math' => $this->math,
            'english' => $this->english,
            'physics' => $this->physics,
            'chemistry' => $this->chemistry,
            'seat_num' => $this->seat_num,
            'biology' => $this->biology,
            'politics' => $this->politics,
            'history' => $this->history,
            'geography' => $this->geography,
            'total' => $this->total,
            'class_rank' => $this->class_rank,
            'school_rank' => $this->school_rank,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'cand_id', $this->cand_id])
            ->andFilterWhere(['like', 'student_id', $this->student_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'test_name', $this->test_name])
            ->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'banji', $this->banji])
            ->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time])
            ->andFilterWhere(['like', 'test_room', $this->test_room])
            ->andFilterWhere(['like', 'test_num', $this->test_num])
            ->andFilterWhere(['like', 'location', $this->location]);


        return $dataProvider;
    }

    public function getTeatInfo($id){
        $testInfo = Test::find()->where(['id' => $id])->one();

        return $testInfo;
    }

    public function getStudentList($testInfo){

        $list = Kaohao::find()->where(['test_num'=>$testInfo->test_num])->orderBy('order asc')->asArray()->all();

        return $list;
    }

    public function insertBaseData($studentList,$type){
        foreach ($studentList as $item){
            (new \yii\db\Query())->createCommand()->insert('score',[
                'cand_id' => $item['cand_num'],
                'student_id' => $item['student_id'],
                'name' => $item['student_name'],
                'test_name' => $item['test_name'],
                'test_num' => $item['test_num'],
                'grade' => $item['grade_name'],
                'banji' => $item['class_name'],
                'test_room' => $item['room_name'],
                'location' => $item['exam_room'],
                'seat_num' => $item['seat_num'],
                'type' => $type,
                'insert_time' => date('Y-m-d H:i:s',time()),
                'update_time' => date('Y-m-d H:i:s',time()),
            ])->execute();
        }
    }

    public function dealExportData($models){
        foreach ($models as &$item){
            $item->type = $item->type == 1 ? '理科' : '文科';
        }

        return $models;
    }
}
