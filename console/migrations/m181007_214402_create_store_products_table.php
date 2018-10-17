<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store_products`.
 */
class m181007_214402_create_store_products_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%store_products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'label_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'price' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-store_products-category_id}}', '{{%store_products}}', 'category_id');
        $this->createIndex('{{%idx-store_products-label_id}}', '{{%store_products}}', 'label_id');

        $this->addForeignKey('{{%fk-store_products-category_id}}', '{{%store_products}}', 'category_id', '{{%store_categories}}', 'id');
        $this->addForeignKey('{{%fk-store_products-label_id}}', '{{%store_products}}', 'label_id', '{{%store_labels}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%store_products}}');
    }
}
