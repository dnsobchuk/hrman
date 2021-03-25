<?php

use yii\db\Migration;

/**
 * Class m210324_123841_create_interview
 */
class m210324_123841_create_interview extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%interview}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string(),
            'status' => $this->smallInteger()->notNull(),
            'reject_reason' => $this->text(),
            'employee_id' => $this->integer()
        ], $tableOptions);

        $this->createIndex('idx-interview-status', '{{%interview}}', 'status');
        $this->createIndex('idx-interview-employee_id', '{{%interview}}', 'employee_id');
        $this->addForeignKey('fk-interview-employee_id', '{{%interview}}', 'employee_id',
            '{{%employee}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%interview}}');
    }
}
