<?php

use yii\db\Migration;

/**
 * Class m181109_053005_create_post_main_img
 */
class m181109_053005_create_post_main_img extends Migration
{
    public function up()
    {
        $this->addColumn('{{%blog_posts}}', 'main_photo_id', $this->integer());

        $this->createIndex('{{%idx-posts-main_photo_id}}', '{{%blog_posts}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-posts-main_photo_id}}', '{{%blog_posts}}', 'main_photo_id', '{{%post_photos}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-posts-main_photo_id}}', '{{%blog_posts}}');
        $this->dropColumn('{{%blog_posts}}', 'main_photo_id');
    }
}
