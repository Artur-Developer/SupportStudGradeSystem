<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

//        INSERT INTO `user` (`id`, `username`, `last_name`, `first_name`, `middle_name`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
//    (1, 'admin', 'Фазылов', 'Артур', 'Эмилевич', 'vINQTtbCtaOXNXRgWqKhI3O6DmFOb2dF', '$2y$13$i7J6onM96I6nGCoA2PCkROOeOy5h/1efsDtWL.kJFmJXuX4/BC7ai', NULL, 'dniwe_dniw@mail.ru', 10, 1487935625, 1537523987),
//(2, 'kurator', 'Горащук', 'Ольга', 'Сергеевна',  'V6I_aR2EGemBL9csGdYNy23F1zD3FRIP', '$2y$13$4H4By83WELCC185fq846Ke6DaYuO78VDZslnoIr5vAlpI5V.y58vq', NULL, 'kurator@mail.ru', 10, 1487946525, 1533046570),
//(3, 'misha', 'Косолапый', 'Миша', 'Медведевич', '4Jb_XLCc6wS6dPbH2odEASf5hJsefOQR', '$2y$13$Qaji./d7yZLrW/jjojLXRuWiGfVOyHsVxcrWHlmrzYFdEg0TCwjbm', NULL, 'misha@mail.ru', 10, 1488121578, 1488121578)

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'last_name' => $this->string()->notNull(),
            'first_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
