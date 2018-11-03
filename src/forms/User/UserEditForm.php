<?php
namespace src\forms\User;

use src\models\User;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UserEditForm
 * @package src\forms\User
 */
class UserEditForm extends Model
{
    public $username;
    public $email;
    public $custom_username;
    public $real_name;
    public $real_surname;
    public $avatar;
    public $description;
    public $soundcloud_link;
    public $discogs_link;
    public $bandcamp_link;
    public $_user;

    /**
     * UserEditForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, array $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->custom_username = $user->custom_username;
        $this->real_name = $user->custom_username;
        $this->real_surname = $user->custom_username;
        $this->description = $user->description;
        $this->soundcloud_link = $user->soundcloud_link;
        $this->discogs_link = $user->discogs_link;
        $this->bandcamp_link = $user->bandcamp_link;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['description', 'custom_username', 'real_name', 'real_surname', 'soundcloud_link', 'discogs_link', 'bandcamp_link'], 'string', 'max' => 255],
            [['avatar'], 'image'],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],

        ];
    }

    public function beforeValidate() : bool
    {
        if (parent::beforeValidate()) {
            $this->avatar = UploadedFile::getInstance($this, 'avatar');
            return true;
        }
        return false;
    }
}
