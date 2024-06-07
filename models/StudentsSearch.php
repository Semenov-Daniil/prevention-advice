<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Students;

/**
 * StudentsSearch represents the model behind the search form of `app\models\Students`.
 */
class StudentsSearch extends Students
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'groups_id'], 'integer'],
            [['fio', 'birthday'], 'safe'],
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
        $query = Students::find()
            ->select([
                '{{%students}}.id', 'fio', 'birthday', '{{%groups}}.title as groups_title'
            ])
            ->innerJoin('{{%groups}}', '{{%groups}}.id = {{%students}}.groups_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'fio' => SORT_ASC,
                ]
            ]
        ]);

        $dataProvider->sort->attributes['groups_title'] = [
            'asc' => ['groups_title' => SORT_ASC],
            'desc' => ['groups_title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birthday' => $this->birthday,
            'groups_id' => $this->groups_id,
        ]);

        $query
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'groups_title', $this->groups_title]);

        return $dataProvider;
    }
}
