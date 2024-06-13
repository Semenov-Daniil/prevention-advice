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
            [['fio', 'group', 'curator'], 'string', 'max' => 255],
            [['reason', 'result', 'protocol', 'decree', 'remark', 'reprimand', 'note', 'liquidation_period', 'memo', 'birthday'], 'safe'],
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
    public function search($advice_id, $params)
    {
        $students = AdvicesStudents::find()
            ->select([
                'students_id'
            ])
            ->where(['advices_id' => $advice_id]);
        
        $this_advice = AdvicesStudents::find()
            ->select([
                'id as this_advice', 'students_id'
            ])
            ->where(['advices_id' => $advice_id]); 

        $this_advice_date = Advices::findOne($advice_id)->date;

        $all_advices_students = AdvicesStudents::find()
            ->select([
                'this_advice as id',
                '{{%advices_students}}.students_id',
                '{{%students}}.fio as fio', 
                '{{%students}}.birthday', 
                '{{%groups}}.title as group', 
                '{{%curators}}.fio as curator',
                'reason' => new \yii\db\Expression('GROUP_CONCAT(reason SEPARATOR \'\n\')'),
                'result' => new \yii\db\Expression('GROUP_CONCAT(result SEPARATOR \'\n\')'),
                'protocol' => new \yii\db\Expression('GROUP_CONCAT(protocol SEPARATOR \'\n\')'),
                'decree' => new \yii\db\Expression('GROUP_CONCAT(decree SEPARATOR \'\n\')'),
                'remark' => new \yii\db\Expression('GROUP_CONCAT(remark SEPARATOR \'\n\')'),
                'reprimand' => new \yii\db\Expression('GROUP_CONCAT(reprimand SEPARATOR \'\n\')'),
                'note' => new \yii\db\Expression('GROUP_CONCAT(note SEPARATOR \'\n\')'),
                'liquidation_period' => new \yii\db\Expression('GROUP_CONCAT(liquidation_period SEPARATOR \'\n\')'),
                'memo' => new \yii\db\Expression('GROUP_CONCAT(memo SEPARATOR \'\n\')'),
            ])
            ->innerJoin('{{%students}}', '{{%students}}.id = {{%advices_students}}.students_id')
            ->innerJoin('{{%advices}}', '{{%advices}}.id = {{%advices_students}}.advices_id')
            ->leftJoin('{{%groups}}', '{{%groups}}.id = {{%students}}.groups_id')
            ->leftJoin('{{%curators}}', '{{%curators}}.id = {{%groups}}.curators_id')
            ->innerJoin(['this_advice' => $this_advice], 'this_advice.students_id = {{%advices_students}}.students_id')
            ->where(['in', '{{%advices_students}}.students_id', $students])
            ->andWhere(['<=', 'date', $this_advice_date])
            ->groupBy(['{{%advices_students}}.students_id', 'this_advice'])
            ->asArray();

        // var_dump('<pre>', $all_advices_students->all());die;

        $dataProvider = new ActiveDataProvider([
            'query' => $all_advices_students,
        ]);

        $dataProvider->sort->attributes['fio'] = [
            'asc' => ['fio' => SORT_ASC],
            'desc' => ['fio' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['birthday'] = [
            'asc' => ['birthday' => SORT_ASC],
            'desc' => ['birthday' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['group'] = [
            'asc' => ['group' => SORT_ASC],
            'desc' => ['group' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['curator'] = [
            'asc' => ['curator' => SORT_ASC],
            'desc' => ['curator' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $all_advices_students->andFilterWhere([
            'birthday' => $this->birthday,
        ]);

        $all_advices_students
            ->andFilterWhere(['like', '{{%students}}.fio', $this->fio])
            ->andFilterWhere(['like', '{{%groups}}.title', $this->group])
            ->andFilterWhere(['like', '{{%curators}}.fio', $this->curator])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'protocol', $this->protocol])
            ->andFilterWhere(['like', 'decree', $this->decree])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'reprimand', $this->reprimand])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'liquidation_period', $this->liquidation_period]);

        return $dataProvider;
    }

    public function searchAdvice($students_id, $params)
    {
        $all_advices_students = AdvicesStudents::find()
            ->select([
                '{{%advices_students}}.id', 'advices_id', 'date', 'reason', 'result', 'protocol', 'decree', 'remark', 'reprimand', 'note', 'liquidation_period', 'memo'
            ])
            ->innerJoin('{{%advices}}', '{{%advices}}.id = {{%advices_students}}.advices_id')
            ->where(['students_id' => $students_id])
            ->orderBy(['date' => SORT_DESC])
            ->asArray();

        $dataProvider = new ActiveDataProvider([
            'query' => $all_advices_students,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $dataProvider->sort->attributes['date'] = [
            'asc' => ['date' => SORT_ASC],
            'desc' => ['date' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function exportData($advice_id)
    {
        $students = AdvicesStudents::find()
            ->select([
                'students_id'
            ])
            ->where(['advices_id' => $advice_id]);
        
        $this_advice = AdvicesStudents::find()
            ->select([
                'id as this_advice', 'students_id'
            ])
            ->where(['advices_id' => $advice_id]); 

        $this_advice_date = Advices::findOne($advice_id)->date;

        $all_advices_students = AdvicesStudents::find()
            ->select([
                '{{%students}}.fio as fio', 
                '{{%students}}.birthday', 
                '{{%groups}}.title as group', 
                '{{%curators}}.fio as curator',
                'reason' => new \yii\db\Expression('GROUP_CONCAT(reason SEPARATOR \'\n\')'),
                'result' => new \yii\db\Expression('GROUP_CONCAT(result SEPARATOR \'\n\')'),
                'protocol' => new \yii\db\Expression('GROUP_CONCAT(protocol SEPARATOR \'\n\')'),
                'decree' => new \yii\db\Expression('GROUP_CONCAT(decree SEPARATOR \'\n\')'),
                'remark' => new \yii\db\Expression('GROUP_CONCAT(remark SEPARATOR \'\n\')'),
                'reprimand' => new \yii\db\Expression('GROUP_CONCAT(reprimand SEPARATOR \'\n\')'),
                'note' => new \yii\db\Expression('GROUP_CONCAT(note SEPARATOR \'\n\')'),
                'liquidation_period' => new \yii\db\Expression('GROUP_CONCAT(liquidation_period SEPARATOR \'\n\')'),
                'memo' => new \yii\db\Expression('GROUP_CONCAT(memo SEPARATOR \'\n\')'),
            ])
            ->innerJoin('{{%students}}', '{{%students}}.id = {{%advices_students}}.students_id')
            ->innerJoin('{{%advices}}', '{{%advices}}.id = {{%advices_students}}.advices_id')
            ->leftJoin('{{%groups}}', '{{%groups}}.id = {{%students}}.groups_id')
            ->leftJoin('{{%curators}}', '{{%curators}}.id = {{%groups}}.curators_id')
            ->innerJoin(['this_advice' => $this_advice], 'this_advice.students_id = {{%advices_students}}.students_id')
            ->where(['in', '{{%advices_students}}.students_id', $students])
            ->andWhere(['<=', 'date', $this_advice_date])
            ->groupBy(['{{%advices_students}}.students_id', 'this_advice'])
            ->asArray()
            ->all();

        $id_str = 1;
        foreach($all_advices_students as $key=>$students) {
            $date = date_create_from_format('Y-m-d', $students['birthday']);
            if ($date) {
                $formattedDate = date_format($date, 'd.m.Y');
                $students['birthday'] = $formattedDate;
            }
            array_unshift($students, $id_str);
            $id_str++;
            $all_advices_students[$key] = $students;
        }  

        return $all_advices_students;
    }
}
