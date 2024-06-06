<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdvicesStudents;
use yii\db\Query;

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
        $query = AdvicesStudents::find()
            ->select('students_id')
            ->where(['advices_id' => $params['id']]);

        $students = AdvicesStudents::find()
            ->select([
                '{{%students}}.id as students_id', 
                '{{%students}}.fio', 
                '{{%students}}.birthday', 
                '{{%groups}}.title as group', 
                '{{%curators}}.fio as curator',
                'reason',
                'result',
                'protocol',
                'decree',
                'remark',
                'reprimand',
                'note',
                'liquidation_period',
                'memo',
            ])
            ->innerJoin('{{%students}}', '{{%students}}.id = {{%advices_students}}.students_id')
            ->innerJoin('{{%groups}}', '{{%groups}}.id = {{%students}}.groups_id')
            ->innerJoin('{{%curators}}', '{{%curators}}.id = {{%groups}}.curators_id')
            ->where(['advices_id' => $params['id']]);

        

        $full_students = AdvicesStudents::find()
            ->select([
                'fio', 
                'birthday', 
                'group', 
                'curator',
                'reason' => new \yii\db\Expression('GROUP_CONCAT(reason SEPARATOR \'; \')'),
                'result' => new \yii\db\Expression('GROUP_CONCAT(result SEPARATOR \'; \')'),
                'protocol' => new \yii\db\Expression('GROUP_CONCAT(protocol SEPARATOR \'; \')'),
                'decree' => new \yii\db\Expression('GROUP_CONCAT(decree SEPARATOR \'; \')'),
                'remark' => new \yii\db\Expression('GROUP_CONCAT(remark SEPARATOR \'; \')'),
                'reprimand' => new \yii\db\Expression('GROUP_CONCAT(reprimand SEPARATOR \'; \')'),
                'note' => new \yii\db\Expression('GROUP_CONCAT(note SEPARATOR \'; \')'),
                'liquidation_period' => new \yii\db\Expression('GROUP_CONCAT(liquidation_period SEPARATOR \'; \')'),
                'memo' => new \yii\db\Expression('GROUP_CONCAT(memo SEPARATOR \'; \')'),
            ])
            ->from(['st' => $students])
            ->where('students_id = st.students_id')
            ->groupBy(['{{%advices_students}}.students_id']);

        var_dump('<pre>', $full_students->all());die;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $params = [
            'advices_id' => 0,
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
            'advices_id' => $this->advices_id,
            'students_id' => $this->students_id,
            'liquidation_period' => $this->liquidation_period,
        ]);

        return $dataProvider;
    }
}
