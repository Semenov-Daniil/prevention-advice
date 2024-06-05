<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%students}}".
 *
 * @property int $id
 * @property string $fio
 * @property string $birthday
 * @property int $groups_id
 *
 * @property AdvicesStudents[] $advicesStudents
 * @property Groups $groups
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%students}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'birthday', 'groups_id'], 'required'],
            [['birthday'], 'safe'],
            [['groups_id'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['groups_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::class, 'targetAttribute' => ['groups_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'birthday' => 'День рождения',
            'groups_id' => 'Группа ID',
        ];
    }

    /**
     * Gets query for [[AdvicesStudents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvicesStudents()
    {
        return $this->hasMany(AdvicesStudents::class, ['students_id' => 'id']);
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasOne(Groups::class, ['id' => 'groups_id']);
    }
}
