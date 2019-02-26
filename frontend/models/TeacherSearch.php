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
            [['id', 'sex', 'duty', 'diploma', 'political_landscape', 'title','group'], 'integer'],
            [['teacher_id', 'name', 'born_time', 'tel', 'qq', 'email', 'pic', 'insert_time', 'update_time'], 'safe'],
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
            'duty' => $this->duty,
            'diploma' => $this->diploma,
            'group' => $this->group,
            'political_landscape' => $this->political_landscape,
            'title' => $this->title,
        ]);

        $query->andFilterWhere(['like', 'teacher_id', $this->teacher_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'born_time', $this->born_time])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'insert_time', $this->insert_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        \Yii::$app->params['sql'] = $query ->createCommand()->getRawSql();;

        return $dataProvider;
    }

    public function dealExportData(&$data){

        foreach ($data as &$item){
            $item['sex'] = $item['sex'] == 1 ? '男' : '女';
            $item['duty'] = (Duty::find()->select('name')->where(['id'=>$item['duty'],'type'=>'2'])->one())->name;
            $item['political_landscape'] = (Political::find()->select('name')->where(['id'=>$item['political_landscape']])->one())->name;
            $item['title'] = (Title::find()->select('name')->where(['id'=> $item['title']])->one())->name;
            $item['diploma'] = (Diploma::find()->select('name')->where(['id'=> $item['diploma']])->one())->name;
            $item['group'] = \Yii::$app->params['groupConfig'][ $item['group']];
            unset($item['id']);
            unset($item['pic']);
            unset($item['insert_time']);
            unset($item['update_time']);
        }
        return $data;
    }
}
