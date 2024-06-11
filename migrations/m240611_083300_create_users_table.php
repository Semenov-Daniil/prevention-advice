<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240611_083300_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'roles_id' => $this->integer()->notNull(),
            'token' => $this->string(255)->unique(),
        ]);

        $this->createIndex('users-roles_id', '{{%users}}', 'roles_id');
        $this->addForeignKey('fk-users-roles_id', '{{%users}}', 'roles_id', '{{%roles}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-users-roles_id', '{{%users}}');
        $this->dropIndex('users-roles_id', '{{%users}}');

        $this->dropTable('{{%users}}');
    }
}
