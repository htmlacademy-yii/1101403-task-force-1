<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task_replies}}`.
 */
class m201003_150717_add_status_column_to_task_replies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%task_replies}}', 'status', "ENUM('new', 'rejected') DEFAULT 'new' NOT NULL");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%task_replies}}', 'status');
    }
}
