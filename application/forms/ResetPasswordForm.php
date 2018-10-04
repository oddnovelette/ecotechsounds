<?php
namespace application\forms;

use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package frontend\forms
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
