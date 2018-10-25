<?php
namespace src\services;

use src\models\User;
use src\forms\LoginForm;

/**
 * Class AuthService
 * @package src\services
 */
class AuthService
{
    public function auth(LoginForm $form) : User
    {
        $user = $this->findByUsernameOrEmail($form->username);
        if (!$user || !User::STATUS_ACTIVE || !$user->validatePassword($form->password)) {
            throw new \DomainException('Incorrect user or password.');
        }
        return $user;
    }

    public function findByUsernameOrEmail($value) : ?User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }
}
