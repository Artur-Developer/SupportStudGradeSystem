<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m181215_080844_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'name_project' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('project');
    }
}
