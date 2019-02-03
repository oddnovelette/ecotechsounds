<?php

use yii\db\Migration;

/**
 * Class m181118_154841_add_roles
 */
class m181118_154841_add_roles extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%auth_items}}', ['type', 'name', 'description'], [
            [1, 'user', 'User'],
            [1, 'admin', 'Admin'],
            [1, 'blogger', 'Blogger'],
            [1, 'privileged', 'Privileged'],
        ]);

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['admin', 'user'],
            ['admin', 'blogger'],
            ['admin', 'privileged'],
            ['blogger', 'user'],
            ['privileged', 'user'],
        ]);

        $this->execute('INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'user\', u.id FROM {{%users}} u ORDER BY u.id');
    }

    public function down()
    {
        $this->delete('{{%auth_items}}', ['name' => ['user', 'admin', 'blogger', 'privileged']]);
    }
}
