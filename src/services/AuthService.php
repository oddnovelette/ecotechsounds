<?php
namespace src\services;

use src\models\User;
use src\forms\LoginForm;
use yii\web\ForbiddenHttpException;

/**
 * Class AuthService
 * @package src\services
 */
class AuthService
{
    public function auth(LoginForm $form) : User
    {
        $user = $this->findByUsernameOrEmail($form->username);

        if (!\Yii::$app->authManager->checkAccess($user->id, 'admin')) {
            throw new ForbiddenHttpException('Forbidden: 403');
        }

        if (!$user || !User::STATUS_ACTIVE || !$user->validatePassword($form->password)) {
            throw new \DomainException('Incorrect user or password.');
        }
        return $user;
    }

    public function socialAuth($network, $client_id) : User
    {
        if ($user = $this->findBySocial($network, $client_id)) {
            return $user;
        }

        $user = User::socialSignup($network, $client_id);
        $this->users->save($user);
        return $user;
    }

    public function findBySocial($network, $client_id) : ?User
    {
        return User::find()->joinWith('socials n')->andWhere(['n.social' => $network, 'n.client_id' => $client_id])->one();
    }

    public function findByUsernameOrEmail($value) : ?User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }
}
