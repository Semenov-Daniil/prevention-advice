<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advices_students}}`.
 */
class m240607_122320_create_advices_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advices_students}}', [
            'id' => $this->primaryKey(),
            'advices_id' => $this->integer()->notNull(),
            'students_id' => $this->integer()->notNull(),
            'reason' => $this->text(),
            'result' => $this->text(),
            'protocol' => $this->text(),
            'decree' => $this->text(),
            'remark' => $this->text(),
            'reprimand' => $this->text(),
            'note' => $this->text(),
            'liquidation_period' => $this->text(),
            'memo' => $this->text(),
        ]);

        $this->createIndex('advices_students-advices_id', '{{%advices_students}}', 'advices_id');
        $this->addForeignKey('fk-advices_students-advices_id', '{{%advices_students}}', 'advices_id', '{{%advices}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('advices_students-students_id', '{{%advices_students}}', 'students_id');
        $this->addForeignKey('fk-advices_students-students_id', '{{%advices_students}}', 'students_id', '{{%students}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-advices_students-advices_id', '{{%advices_students}}');
        $this->dropIndex('advices_students-advices_id', '{{%advices_students}}');

        $this->dropForeignKey('fk-advices_students-students_id', '{{%advices_students}}');
        $this->dropIndex('advices_students-students_id', '{{%advices_students}}');

        $this->dropTable('{{%advices_students}}');
    }
}
