<?php
namespace application\services;

use application\models\User;
use application\forms\{PasswordResetRequestForm, ResetPasswordForm};
use Yii;
use yii\mail\MailerInterface;

/**
 * Class PasswordResetService
 * @package frontend\services
 */
class PasswordResetService
{
    private $mailer;

    /**
     * PasswordResetService constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Requests password resetting from a model form
     * @param PasswordResetRequestForm $form
     * @return void
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function request(PasswordResetRequestForm $form) : void
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        if (!empty($this->password_reset_token) && User::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Password resetting is already requested.');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

        if (!$user->save()) {
            throw new \RuntimeException('Saving error occured.');
        }

        $sent = $this->mailer->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Email sending error occured.');
        }
    }

    /**
     * @param string $token
     * @return void
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function validateToken(string $token) : void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }

        if (!User::findByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    /**
     * @param string $token
     * @param ResetPasswordForm $form
     * @return void
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function reset(string $token, ResetPasswordForm $form) : void
    {
        $user = User::findByPasswordResetToken($token);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->resetPassword($form->password);
        if (!$user->save()) {
            throw new \RuntimeException('Saving error occured.');
        }
    }

}