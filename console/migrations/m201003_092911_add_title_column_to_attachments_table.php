<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attachments}}`.
 */
class m201003_092911_add_title_column_to_attachments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachments}}', 'title', $this->string(128)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachments}}', 'title');
    }
}
