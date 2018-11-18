<?php

use yii\db\Migration;

/**
 * Class m181109_020043_create_user_socials
 */
class m181109_020043_create_user_socials extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_socials}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'client_id' => $this->string()->notNull(),
            'network' => $this->string(16)->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_socials-client-name}}', '{{%user_socials}}', ['client_id', 'network'], true);
        $this->createIndex('{{%idx-user_socials-user_id}}', '{{%user_socials}}', 'user_id');
        $this->addForeignKey('{{%fk-user_socials-user_id}}', '{{%user_socials}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_socials}}');
    }
}
