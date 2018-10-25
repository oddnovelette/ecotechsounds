<?php
namespace src\forms;

use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package src\forms
 */
class ResetPasswordForm extends Model
{
    public $password;

    public function rules() : array
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
}
