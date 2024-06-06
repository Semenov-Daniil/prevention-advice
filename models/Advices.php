<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%advices}}".
 *
 * @property int $id
 * @property string $date
 *
 * @property AdvicesStudents[] $advicesStudents
 */
class Advices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advices}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['date'], 'unique', 'message' => 'Дата уже занята!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
        ];
    }

    /**
     * Gets query for [[AdvicesStudents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvicesStudents()
    {
        return $this->hasMany(AdvicesStudents::class, ['advices_id' => 'id']);
    }
}
