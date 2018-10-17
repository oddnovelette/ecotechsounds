<?php

use yii\db\Migration;

/**
 * Class m181009_224917_create_product_img
 */
class m181009_224917_create_product_img extends Migration
{
    public function up()
    {
        $this->addColumn('{{%store_products}}', 'main_photo_id', $this->integer());

        $this->createIndex('{{%idx-store_products-main_photo_id}}', '{{%store_products}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-store_products-main_photo_id}}', '{{%store_products}}', 'main_photo_id', '{{%store_photos}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-store_products-main_photo_id}}', '{{%store_products}}');
        $this->dropColumn('{{%store_products}}', 'main_photo_id');
    }
}
