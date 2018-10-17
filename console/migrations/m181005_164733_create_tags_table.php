<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 */
class m181005_164733_create_tags_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%store_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-store_tags-slug}}', '{{%store_tags}}', 'slug', true);
    }

    public function down()
    {
        $this->dropTable('{{%store_tags}}');
    }
}
