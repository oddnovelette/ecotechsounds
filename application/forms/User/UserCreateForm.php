<?php
namespace application\forms\User;

use application\models\User;
use yii\base\Model;

/**
 * Class UserCreateForm
 * @package application\forms\User
 */
class UserCreateForm extends Model
{
    public $username, $email, $password;

    public function rules() : array
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
        ];
    }
}