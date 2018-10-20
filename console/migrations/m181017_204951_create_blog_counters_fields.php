<?php

use yii\db\Migration;

/**
 * Class m181017_204951_create_blog_counters_fields
 */
class m181017_204951_create_blog_counters_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%blog_posts}}', 'comments_counter', $this->integer()->notNull());
        $this->update('{{%blog_posts}}', ['comments_counter' => 0]);

        $this->addColumn('{{%blog_posts}}', 'views_counter', $this->integer()->notNull());
        $this->update('{{%blog_posts}}', ['views_counter' => 0]);

        $this->addColumn('{{%blog_posts}}', 'likes_counter', $this->integer()->notNull());
        $this->update('{{%blog_posts}}', ['likes_counter' => 0]);
    }

    public function down()
    {
        $this->dropColumn('{{%blog_posts}}', 'comments_counter');
        $this->dropColumn('{{%blog_posts}}', 'views_counter');
        $this->dropColumn('{{%blog_posts}}', 'likes_counter');
    }
}
