<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%curators}}`.
 */
class m240607_120904_create_curators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%curators}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%curators}}');
    }
}
