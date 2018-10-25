<?php
namespace src\forms;

use yii\base\Model;
use src\models\User;

/**
 * Class PasswordResetRequestForm
 * @package src\forms
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules() : array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }
}
