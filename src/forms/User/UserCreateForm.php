<?php
namespace src\forms\User;

use src\models\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class UserCreateForm
 * @package src\forms\User
 */
class UserCreateForm extends Model
{
    public $username, $email, $password, $role;

    public function rules() : array
    {
        return [
            [['username', 'email', 'role'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function rolesList() : array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}
