<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%groups}}".
 *
 * @property int $id
 * @property string $title
 * @property int $curators_id
 *
 * @property Curators $curators
 * @property Students[] $students
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%groups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'curators_id'], 'required'],
            [['curators_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['curators_id'], 'exist', 'skipOnError' => true, 'targetClass' => Curators::class, 'targetAttribute' => ['curators_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'curators_id' => 'Куратор ID',
        ];
    }

    /**
     * Gets query for [[Curators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurators()
    {
        return $this->hasOne(Curators::class, ['id' => 'curators_id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Students::class, ['groups_id' => 'id']);
    }
}
