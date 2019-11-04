<?php
namespace Htmlacademy;

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
    const STATUS_NEW = ['' => 'new'];
    const STATUS_COMPLETE = ['complete' => 'completed'];
    const STATUS_CANCEL = ['cancel' => 'cancelled'];
    const STATUS_REFUSE = ['refuse' => 'failed'];
    const STATUS_APPOINT = ['appoint' => 'in progress'];

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
    public function showActions(): array
    {
        $actions = [self::ACTION_ANSWER, self::ACTION_COMPLETE, self::ACTION_CANCEL, self::ACTION_REFUSE, self::ACTION_APPOINT];
        return $actions;
    }

    /** Возвращает список статусов
     *
     * @return array
     */
    public function showStatuses(): array
    {
        $statuses = [
            self::STATUS_NEW[''],
            self::STATUS_COMPLETE['complete'],
            self::STATUS_CANCEL['cancel'],
            self::STATUS_REFUSE['refuse'],
            self::STATUS_APPOINT['appoint']
        ];
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
            self::STATUS_COMPLETE,
            self::STATUS_CANCEL,
            self::STATUS_REFUSE,
            self::STATUS_APPOINT
        ];
        $statusNew = $this->statusActive;
        foreach ($connections as $key => $value) {
            foreach ($value as $act => $status) {
                if ($action === $act) {
                    $statusNew = $status;
                }
            }
        }
        return $statusNew;
    }
}


