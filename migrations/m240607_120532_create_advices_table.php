<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advices}}`.
 */
class m240607_120532_create_advices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advices}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advices}}');
    }
}
