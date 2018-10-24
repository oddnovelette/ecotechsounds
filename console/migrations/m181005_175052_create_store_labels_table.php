<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store_labels`.
 */
class m181005_175052_create_store_labels_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%store_labels}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-store_labels-slug}}', '{{%store_labels}}', 'slug', true);
    }

    public function down()
    {
        $this->dropTable('{{%store_labels}}');
    }
}
