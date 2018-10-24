<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_likes`.
 */
class m181020_025110_create_post_likes_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user_post_likes}}', [
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-user_post_likes}}', '{{%user_post_likes}}', ['user_id', 'post_id']);

        $this->createIndex('{{%idx-user_post_likes-user_id}}', '{{%user_post_likes}}', 'user_id');
        $this->createIndex('{{%idx-user_post_likes-post_id}}', '{{%user_post_likes}}', 'post_id');

        $this->addForeignKey('{{%fk-user_post_likes-user_id}}', '{{%user_post_likes}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_post_likes-post_id}}', '{{%user_post_likes}}', 'post_id', '{{%blog_posts}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%user_post_likes}}');
    }
}
