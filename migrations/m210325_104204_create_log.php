<?php

use yii\db\Migration;

/**
 * Class m210325_104204_create_log
 */
class m210325_104204_create_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'message' => $this->text(),
            'created_at' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx-log-user_id', '{{%log}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log}}');
    }
}
