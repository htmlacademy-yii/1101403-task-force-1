<?php
namespace Htmlacademy\Logic;

class Task
{
    /**
     * Константы возможных действий
     */
    const ACTION_ANSWER = 'answer';
    const ACTION_COMPLETE = 'complete';
    const ACTION_CANCEL = 'cancel';
    const ACTION_REFUSE = 'refuse';
    const ACTION_APPOINT = 'appoint';

    /**
     * Константы возможных статусов
     */
    const STATUS_NEW = 'new';
    const STATUS_COMPLETE = 'completed';
    const STATUS_CANCEL = 'cancelled';
    const STATUS_REFUSE = 'failed';
    const STATUS_APPOINT = 'in progress';

    /**
     * Константы возможных ролей
     */
    const ROLE_CLIENT = 'client';
    const ROLE_EXECUTIVE = 'executive';

    /**
     * id заказчика
     * @var int
     */
    public $idClient;
    /**
     * id исполнителя
     * @var int
     */
    public $idExecutive;
    /**
     * Дата окончания существования задания
     * @var string
     */
    public $dtEnd;
    /**
     * статус задания
     * @var string
     */
    public $statusActive;

    /**
     * Конструктор класса Task
     * @param $idClient
     * @param $idExecutive
     * @param $dtEnd
     * @param string $statusActive
     */
    public function __construct($idClient, $idExecutive, $dtEnd, $statusActive = 'new')
    {
        $this->idClient = $idClient;
        $this->idExecutive = $idExecutive;
        $this->dtEnd = $dtEnd;
        $this->statusActive = $statusActive;
    }

    /**
     * Возвращает список действий
     *
     * @return array $actions
     */
    public function getActions(): array
    {
        $actions = [self::ACTION_ANSWER, self::ACTION_COMPLETE, self::ACTION_CANCEL, self::ACTION_REFUSE, self::ACTION_APPOINT];
        return $actions;
    }

    /** Возвращает список статусов
     *
     * @return array
     */
    public function getStatuses(): array
    {
        $statuses = [self::STATUS_NEW, self::STATUS_COMPLETE, self::STATUS_CANCEL, self::STATUS_REFUSE, self::STATUS_APPOINT];
        return $statuses;
    }

    /** Возвращает статус, в который перейдет задача для указанного действия
     *
     * @param string $action - действие
     * @return string|null $statusNew
     */
    public function ifAction(string $action): string
    {
        $connections = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETE,
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_REFUSE => self::STATUS_REFUSE,
            self::ACTION_APPOINT => self::STATUS_APPOINT,
            self::ACTION_ANSWER => $this->statusActive
        ];
        $statusNew = null;
        if (array_key_exists($action, $connections)) {
            $statusNew = $connections[$action];
        }
        return $statusNew;
    }
}


