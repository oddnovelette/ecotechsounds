<?php
namespace src\services;

use src\forms\ContactForm;
use yii\mail\MailerInterface;

/**
 * Class FeedbackService
 * @package src\services
 */
class FeedbackService
{
    private $adminEmail, $mailer;

    /**
     * FeedbackService constructor.
     * @param $adminEmail
     * @param MailerInterface $mailer
     */
    public function __construct($adminEmail, MailerInterface $mailer)
    {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    /**
     * @param ContactForm $form
     * @return void
     * @throws \RuntimeException
     */
    public function send(ContactForm $form) : void
    {
        $sent = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Email sending error occured.');
        }
    }
}