<?php
namespace Htmlacademy\Logic\Actions;

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
     * @var int
     */
    protected $userId;


    /**
     * Конструктор класса AbstractAction.
     * @param $role string
     * @param $status string
     * @param $userId int
     */
    public function __construct(string $role, string $status, int $userId)
    {
        $this->role = $role;
        $this->status = $status;
        $this->userId = $userId;
    }

    abstract public static function getTitle();

    abstract public static function getInnerName();

    abstract public static function isPermitted(int $userId, int $roleId);
}
