<?php

use yii\db\Migration;

/**
 * Handles the creation of table `errors`.
 * Has foreign keys to the tables:
 *
 * - `project`
 */
class m181215_081852_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'addressed_id' => $this->integer()->notNull(),
            'image' => $this->string(255),
            'message' => $this->text()->notNull(),
            'create_date' => $this->dateTime()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {


        $this->dropTable('message');
    }
}
