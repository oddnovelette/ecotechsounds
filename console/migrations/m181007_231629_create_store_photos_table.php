<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store_photos`.
 */
class m181007_231629_create_store_photos_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%store_photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-store_photos-product_id}}', '{{%store_photos}}', 'product_id');

        $this->addForeignKey('{{%fk-store_photos-product_id}}', '{{%store_photos}}', 'product_id', '{{%store_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%store_photos}}');
    }
}
