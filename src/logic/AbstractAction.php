<?php
namespace Htmlacademy\Logic;

abstract class AbstractAction
{
    /**
     * роль юзера
     * @var string
     */
    protected $role;

    /**
     * статус задания
     * @var string
     */
    protected $status;


    /**
     * Конструктор класса AbstractAction.
     * @param $role string
     * @param $status string
     * @param $userId int
     */
    function __construct($role, $status, $userId)
    {
        $this->role = $role;
        $this->status = $status;
        $this->userId = $userId;
    }

    abstract static function getTitle();

    abstract static function getInnerName();

    abstract static function isPermitted($userId, $roleId);
}
