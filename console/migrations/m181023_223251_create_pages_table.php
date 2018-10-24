<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages`.
 */
class m181023_223251_create_pages_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
            'content' => 'MEDIUMTEXT',
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-pages_-slug}}', '{{%pages}}', 'slug', true);
    }

    public function down()
    {
        $this->dropTable('{{%pages}}');
    }
}
