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
     */
    function __construct($role, $status)
    {
        $this->role = $role;
        $this->status = $status;
    }

    abstract static function getTitle();

    abstract static function getInnerName();

    abstract static function isPermitted();
}
