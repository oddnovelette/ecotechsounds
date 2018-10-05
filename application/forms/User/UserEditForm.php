<?php
namespace application\forms\User;

use application\models\User;
use yii\base\Model;

/**
 * Class UserEditForm
 * @package application\forms\User
 */
class UserEditForm extends Model
{
    public $username, $email, $_user;

    /**
     * UserEditForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, array $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }
}
