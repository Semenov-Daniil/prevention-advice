<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%advices_students}}".
 *
 * @property int $id
 * @property int $advices_id
 * @property int $students_id
 * @property string $reason
 * @property string $result
 * @property string $protocol
 * @property string $decree
 * @property string $remark
 * @property string $reprimand
 * @property string $note
 * @property string $liquidation_period
 * @property string $memo
 *
 * @property Advices $advices
 * @property Students $students
 */
class AdvicesStudents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advices_students}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['advices_id', 'students_id', 'reason', 'result', 'protocol', 'decree', 'remark', 'reprimand', 'note', 'liquidation_period', 'memo'], 'required'],
            [['advices_id', 'students_id'], 'integer'],
            [['reason', 'result', 'protocol', 'decree', 'remark', 'reprimand', 'note', 'memo'], 'string'],
            [['liquidation_period'], 'safe'],
            [['advices_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advices::class, 'targetAttribute' => ['advices_id' => 'id']],
            [['students_id'], 'exist', 'skipOnError' => true, 'targetClass' => Students::class, 'targetAttribute' => ['students_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advices_id' => 'Advices ID',
            'students_id' => 'Students ID',
            'reason' => 'Причина вызова на СП',
            'result' => 'Результат СП',
            'protocol' => 'Протокол',
            'decree' => 'Приказ',
            'remark' => 'Замечание',
            'reprimand' => 'Выговор',
            'note' => 'Примечание',
            'liquidation_period' => 'Срок ликвидации',
            'memo' => 'Служебная записка от куратора',
        ];
    }

    /**
     * Gets query for [[Advices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvices()
    {
        return $this->hasOne(Advices::class, ['id' => 'advices_id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(Students::class, ['id' => 'students_id']);
    }
}