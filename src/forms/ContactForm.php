<?php
namespace src\forms;

use yii\base\Model;

/**
 * Class ContactForm
 * @package src\forms
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    public function rules() : array
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }
}
