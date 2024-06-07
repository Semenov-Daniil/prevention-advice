<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%groups}}`.
 */
class m240607_121125_create_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%groups}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'curators_id' => $this->integer(),
        ]);

        $this->createIndex('groups-curators_id', '{{%groups}}', 'curators_id');
        $this->addForeignKey('fk-groups-curators_id', '{{%groups}}', 'curators_id', '{{%curators}}', 'id', 'SET NULL', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-groups-curators_id', '{{%groups}}');
        $this->dropIndex('groups-curators_id', '{{%groups}}');

        $this->dropTable('{{%groups}}');
    }
}
