<?php

use yii\db\Migration;

/**
 * Handles the creation of table `answer_message`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m181215_093618_create_answer_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('answer_message', [
            'id' => $this->primaryKey(),
            'support_user_id' => $this->integer()->notNull(),
            'answer_message' => $this->text(),
            'image' => $this->string(255),
            'create_date' => $this->dateTime()->notNull(),
        ]);

        // creates index for column `support_user_id`
        $this->createIndex(
            'idx-answer_message-support_user_id',
            'answer_message',
            'support_user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-answer_message-support_user_id',
            'answer_message',
            'support_user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-answer_message-support_user_id',
            'answer_message'
        );

        // drops index for column `support_user_id`
        $this->dropIndex(
            'idx-answer_message-support_user_id',
            'answer_message'
        );

        $this->dropTable('answer_message');
    }
}
