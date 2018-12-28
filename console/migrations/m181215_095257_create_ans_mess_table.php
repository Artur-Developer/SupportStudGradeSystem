<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ans_mess`.
 * Has foreign keys to the tables:
 *
 * - `message`
 * - `answer_message`
 */
class m181215_095257_create_ans_mess_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ans_mess', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer()->notNull(),
            'answer_message_id' => $this->integer()->notNull(),
            'addressed_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `message_id`
        $this->createIndex(
            'idx-ans_mess-message_id',
            'ans_mess',
            'message_id'
        );

        // add foreign key for table `message`
        $this->addForeignKey(
            'fk-ans_mess-message_id',
            'ans_mess',
            'message_id',
            'message',
            'id',
            'CASCADE'
        );

        // creates index for column `answer_message_id`
        $this->createIndex(
            'idx-ans_mess-answer_message_id',
            'ans_mess',
            'answer_message_id'
        );

        // add foreign key for table `answer_message`
        $this->addForeignKey(
            'fk-ans_mess-answer_message_id',
            'ans_mess',
            'answer_message_id',
            'answer_message',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `message`
        $this->dropForeignKey(
            'fk-ans_mess-message_id',
            'ans_mess'
        );

        // drops index for column `message_id`
        $this->dropIndex(
            'idx-ans_mess-message_id',
            'ans_mess'
        );

        // drops foreign key for table `answer_message`
        $this->dropForeignKey(
            'fk-ans_mess-answer_message_id',
            'ans_mess'
        );

        // drops index for column `answer_message_id`
        $this->dropIndex(
            'idx-ans_mess-answer_message_id',
            'ans_mess'
        );

        $this->dropTable('ans_mess');
    }
}
