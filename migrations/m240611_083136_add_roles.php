<?php

use yii\db\Migration;

/**
 * Class m240611_083136_add_roles
 */
class m240611_083136_add_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%roles}}', 
            [
                'id',
                'title'
            ], 
            [
                [
                    1,
                    'Admin'
                ],
                [
                    2,
                    'User'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%roles}}', ['id' => 1]);
        $this->delete('{{%roles}}', ['id' => 2]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240611_083136_add_roles cannot be reverted.\n";

        return false;
    }
    */
}
