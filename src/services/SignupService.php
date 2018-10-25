<?php
namespace src\services;

use src\models\User;
use src\forms\SignupForm;
use yii\mail\MailerInterface;

/**
 * Class SignupService
 * @package src\services
 */
class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param SignupForm $form
     * @return void
     * @throws \RuntimeException
     * @throws \DomainException
     */
    public function signup(SignupForm $form) : void
    {
        $user = User::initiateUsersSignup($form->username, $form->email, $form->password);
        if (!$user->save()) {
            throw new \RuntimeException('User signup error occured.');
        }

        $sent = $this->mailer->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Signup confirm for ' . \Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Email sending error occured.');
        }
    }

    /**
     * @param string $token
     * @return void
     * @throws \RuntimeException
     * @throws \DomainException
     */
    public function confirm(string $token) : void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirmation token.');
        }

        /* @var $user User */
        $user = User::findOne(['email_confirm_token' => $token]);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->signupConfirmation();
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }
}
