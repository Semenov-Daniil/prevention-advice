<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%students}}`.
 */
class m240607_121758_create_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%students}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull(),
            'birthday' => $this->date()->notNull(),
            'groups_id' => $this->integer()->null(),
        ]);

        $this->createIndex('students-groups_id', '{{%students}}', 'groups_id');
        $this->addForeignKey('fk-students-groups_id', '{{%students}}', 'groups_id', '{{%groups}}', 'id', 'SET NULL', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-students-groups_id', '{{%students}}');
        $this->dropIndex('students-groups_id', '{{%students}}');

        $this->dropTable('{{%students}}');
    }
}
