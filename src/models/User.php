<?php
namespace src\models;

use src\models\Blog\Post;
use src\models\Blog\PostLike;
use src\queryModels\UserQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * @package common\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $email_confirm_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property PostLike[] $postLikes
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_AWAIT = 0;
    const STATUS_ACTIVE = 10;

    /**
     * User register constructor
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function initiateUsersSignup(string $username, string $email, string $password) : self
    {
        $user = new self();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->created_at = time();
        $user->status = self::STATUS_AWAIT;
        $user->email_confirm_token = Yii::$app->security->generateRandomString();
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    /**
     * User manual creating constructor
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function create(string $username, string $email, string $password) : self
    {
        $user = new self();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    /**
     * @param string $username
     * @param string $email
     * @return void
     */
    public function edit(string $username, string $email) : void
    {
        $this->username = $username;
        $this->email = $email;
        $this->updated_at = time();
    }

    public function signupConfirmation() : void
    {
        if (!$this->status === self::STATUS_AWAIT) {
            throw new \DomainException('User is already confirmed.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->email_confirm_token = null;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['postLikes'],
            ],
        ];
    }

    public function isActive() : bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) : ?self
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Password resetting is not requested.');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    /////////////// Likes & Dislikes ////////////////////

    public function submitPostLike($postId) : void
    {
        $post_likes = $this->postLikes;
        foreach ($post_likes as $like) {
            if ($like->isForPost($postId)) {
                throw new \DomainException('Post is already liked.');
            }
        }
        $post_likes[] = PostLike::create($postId);
        $this->postLikes = $post_likes;
        $post = Post::findOne($postId);
        $post->updateCounters(['likes_counter' => 1]);
    }

    public function postAlreadyLiked($postId) : bool
    {
        $post_likes = $this->postLikes;
        foreach ($post_likes as $like) {
            if ($like->isForPost($postId)) {
                return false;
            }
        }
        return true;
    }

    public function removeFromPostLikesList($postId) : void
    {
        $post_likes = $this->postLikes;
        foreach ($post_likes as $i => $like) {
            if ($like->isForPost($postId)) {
                unset($post_likes[$i]);
                $this->postLikes = $post_likes;
                $post = Post::findOne($postId);
                $post->updateCounters(['likes_counter' => -1]);
                return;
            }
        }
        throw new \DomainException('Like is not found.');
    }

    public function getPostLikes() : ActiveQuery
    {
        return $this->hasMany(PostLike::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) : ?self
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) : ?self
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token) : bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return UserQuery
     */
    public static function find() : UserQuery
    {
        return new UserQuery(get_called_class());
    }

}
