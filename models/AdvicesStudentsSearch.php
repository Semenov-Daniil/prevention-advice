<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdvicesStudents;

/**
 * AdvicesStudentsSearch represents the model behind the search form of `app\models\AdvicesStudents`.
 */
class AdvicesStudentsSearch extends AdvicesStudents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'advices_id', 'students_id'], 'integer'],
            [['reason', 'result', 'protocol', 'decree', 'remark', 'reprimand', 'note', 'liquidation_period', 'memo'], 'safe'],
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
        $query = AdvicesStudents::find();

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
            'advices_id' => $this->advices_id,
            'students_id' => $this->students_id,
            'liquidation_period' => $this->liquidation_period,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'protocol', $this->protocol])
            ->andFilterWhere(['like', 'decree', $this->decree])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'reprimand', $this->reprimand])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}
