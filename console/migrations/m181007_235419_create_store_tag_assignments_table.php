<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store_tag_assignments`.
 */
class m181007_235419_create_store_tag_assignments_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%store_tag_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-store_tag_assignments}}', '{{%store_tag_assignments}}', ['product_id', 'tag_id']);

        $this->createIndex('{{%idx-store_tag_assignments-product_id}}', '{{%store_tag_assignments}}', 'product_id');
        $this->createIndex('{{%idx-store_tag_assignments-tag_id}}', '{{%store_tag_assignments}}', 'tag_id');

        $this->addForeignKey('{{%fk-store_tag_assignments-product_id}}', '{{%store_tag_assignments}}', 'product_id', '{{%store_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-store_tag_assignments-tag_id}}', '{{%store_tag_assignments}}', 'tag_id', '{{%store_tags}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%store_tag_assignments}}');
    }
}
