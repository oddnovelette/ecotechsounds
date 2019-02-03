<?php
namespace src\services;

use yii\rbac\ManagerInterface;

/**
 * Class RoleManager
 * @package src\services
 */
class RoleManager
{
    private $manager;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function assign($userId, $name): void
    {
        if (!$role = $this->manager->getRole($name)) {
            throw new \DomainException('Role "' . $name . '" doesn`t exist.');
        }

        $this->manager->revokeAll($userId);
        $this->manager->assign($role, $userId);
    }
}
