<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 */
class m181215_164553_create_addressed_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%addressed}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'type_addressed' => $this->string(100)->notNull(),
            'type_message' => $this->string(100)->notNull(),
            'fio_addressed' => $this->string(255)->notNull(),
            'key_user' => $this->string(255)->notNull(),
            'key_message' => $this->string(255)->notNull(),
            'path_error' => $this->string(255),
            'token' => $this->string()->notNull()->unique(),
            'expired_at' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-addressed-project_id',
            'addressed',
            'project_id'
        );

        $this->addForeignKey(
            'fk-addressed-project_id',
            'addressed',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-message-addressed_id',
            'message',
            'addressed_id'
        );

        $this->addForeignKey(
            'fk-message-addressed_id',
            'message',
            'addressed_id',
            'addressed',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-ans_mess-addressed_id',
            'ans_mess',
            'addressed_id'
        );

        $this->addForeignKey(
            'fk-ans_mess-addressed_id',
            'ans_mess',
            'addressed_id',
            'addressed',
            'id',
            'CASCADE'
        );

    }
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-message-addressed_id',
            'message'
        );

        $this->dropIndex(
            'idx-message-addressed_id',
            'message'
        );

        $this->dropForeignKey(
            'fk-addressed-project_id',
            'addressed'
        );

        $this->dropIndex(
            'idx-addressed-project_id',
            'addressed'
        );

        $this->dropForeignKey(
            'fk-ans_mess-addressed_id',
            'ans_mess'
        );

        $this->dropIndex(
            'idx-ans_mess-addressed_id',
            'ans_mess'
        );


        $this->dropTable('{{%addressed}}');
    }
}
