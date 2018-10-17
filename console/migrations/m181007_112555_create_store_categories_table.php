<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store_categories`.
 */
class m181007_112555_create_store_categories_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%store_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'sort' => $this->integer()->notNull(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-store_categories-slug}}', '{{%store_categories}}', 'slug', true);
    }

    public function down()
    {
        $this->dropTable('{{%store_categories}}');
    }
}
