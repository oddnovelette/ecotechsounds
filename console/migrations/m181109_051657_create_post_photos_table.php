<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_photos`.
 */
class m181109_051657_create_post_photos_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%post_photos}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_photos-post_id}}', '{{%post_photos}}', 'post_id');

        $this->addForeignKey('{{%fk-blog_photos-post_id}}', '{{%post_photos}}', 'post_id', '{{%blog_posts}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%post_photos}}');
    }
}
