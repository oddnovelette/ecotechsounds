<?php
namespace src\services;

use src\forms\User\{UserEditForm, UserCreateForm};
use src\models\User;

/**
 * Class UserService
 * @package src\services
 */
class UserService
{
    private $roles;

    /**
     * UserService constructor.
     * @param RoleManager $roles
     */
    public function __construct(RoleManager $roles)
    {
        $this->roles = $roles;
    }

    /**
     * User manual creating method
     * @param UserCreateForm $form
     * @return User
     * @throws \RuntimeException
     */
    public function create(UserCreateForm $form) : User
    {
        $user = User::create($form->username, $form->email, $form->password);

        \Yii::$app->db->transaction(function () use ($user, $form) {
            if (!$user->save()) {
                throw new \RuntimeException('User creating error occured.');
            }
            $this->roles->assign($user->id, $form->role);
        });

        return $user;
    }

    /**
     * User manual editing service method
     * @param int $id
     * @param UserEditForm $form
     * @return void
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function edit(int $id, UserEditForm $form) : void
    {
        $user = User::findOne(['id' => $id]);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->edit(
            $form->username,
            $form->email,
            $form->description,
            $form->user_from,
            $form->real_name,
            $form->real_surname,
            $form->soundcloud_link,
            $form->discogs_link,
            $form->bandcamp_link
        );

        if ($form->avatar) $user->setAvatar($form->avatar);

        \Yii::$app->db->transaction(function () use ($user, $form) {
            if (!$user->save()) {
                throw new \RuntimeException('Editing error occured.');
            }
            $this->roles->assign($user->id, $form->role);
        });
    }

    public function assignRole($id, $role) : void
    {
        $user = User::findOne(['id' => $id]);
        if (!$user) throw new \DomainException('User is not found.');

        $this->roles->assign($user->id, $role);
    }

    public function remove($id) : void
    {
        $user = User::findOne(['id' => $id]);
        if (!$user) throw new \DomainException('User is not found.');

        $this->repository->remove($user);
    }
}
