<?php

use yii\db\Migration;

/**
 * Class m181025_195309_add_additional_user_fields
 */
class m181025_195309_add_additional_user_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'role', $this->string(64));
        $this->update('{{%users}}', ['role' => 'user']);

        $this->addColumn('{{%users}}', 'privileged', $this->smallInteger()->notNull()->defaultValue(0)); // pro account if(1)
        $this->addColumn('{{%users}}', 'type', $this->smallInteger()->notNull()->defaultValue(0)); // resident, customer etc.
        $this->addColumn('{{%users}}', 'account_privacy', $this->smallInteger()->notNull()->defaultValue(0)); // public account if(1)
        $this->addColumn('{{%users}}', 'email_privacy', $this->smallInteger()->notNull()->defaultValue(0)); // public email if(1)
        $this->addColumn('{{%users}}', 'custom_username', $this->string(50));
        $this->addColumn('{{%users}}', 'real_name', $this->string(50));
        $this->addColumn('{{%users}}', 'real_surname', $this->string(50));
        $this->addColumn('{{%users}}', 'description', $this->string());
        $this->addColumn('{{%users}}', 'avatar', $this->string());
        $this->addColumn('{{%users}}', 'soundcloud_link', $this->string());
        $this->addColumn('{{%users}}', 'discogs_link', $this->string());
        $this->addColumn('{{%users}}', 'bandcamp_link', $this->string());

        $this->createIndex('{{%idx-post-user_id}}', '{{%blog_posts}}', 'user_id');
    }

    public function down()
    {
        $this->dropColumn('{{%users}}', 'role');
        $this->dropColumn('{{%users}}', 'privileged');
        $this->dropColumn('{{%users}}', 'type');
        $this->dropColumn('{{%users}}', 'account_privacy');
        $this->dropColumn('{{%users}}', 'email_privacy');
        $this->dropColumn('{{%users}}', 'custom_username');
        $this->dropColumn('{{%users}}', 'real_name');
        $this->dropColumn('{{%users}}', 'real_surname');
        $this->dropColumn('{{%users}}', 'description');
        $this->dropColumn('{{%users}}', 'avatar');
        $this->dropColumn('{{%users}}', 'soundcloud_link');
        $this->dropColumn('{{%users}}', 'discogs_link');
        $this->dropColumn('{{%users}}', 'bandcamp_link');
    }
}
