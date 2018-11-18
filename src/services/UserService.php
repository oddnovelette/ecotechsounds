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
    /**
     * User manual creating method
     * @param UserCreateForm $form
     * @return User
     * @throws \RuntimeException
     */
    public static function create(UserCreateForm $form) : User
    {
        $user = User::create($form->username, $form->email, $form->password);
        if (!$user->save()) {
            throw new \RuntimeException('User creating error occured.');
        }

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
    public static function edit(int $id, UserEditForm $form) : void
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
        if (!$user->save()) {
            throw new \RuntimeException('Editing error occured.');
        }
    }
}
