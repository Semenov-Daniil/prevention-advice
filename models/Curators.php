<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%curators}}".
 *
 * @property int $id
 * @property string $fio
 *
 * @property Groups[] $groups
 */
class Curators extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%curators}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::class, ['curators_id' => 'id']);
    }
}
