<?php
namespace Htmlacademy\Logic;
use Htmlacademy\ErrorHandlers\ErrorHandler;

class AvailableActions
{
    /**
     * Константы возможных действий
     */
    const ACTION_REPLY = ReplyAction::class;
    const ACTION_COMPLETE = CompleteAction::class;
    const ACTION_CANCEL = CancelAction::class;
    const ACTION_REFUSE = RefuseAction::class;
    const ACTION_APPOINT = AppointAction::class;

    /**
     * Константы возможных статусов
     */
    const STATUS_NEW = 'new';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';
    const STATUS_IN_PROGRESS = 'in progress';

    /**
     * Константы возможных ролей
     */
    const ROLE_CLIENT = 'client';
    const ROLE_EXECUTIVE = 'executive';

    /**
     * id заказчика
     * @var int
     */
    public $clientId;
    /**
     * id исполнителя
     * @var int
     */
    public $executiveId;
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
     * Конструктор класса AvailableActions
     * @param int $clientId
     * @param int $executiveId
     * @param string $dtEnd
     * @param string $statusActive
     */
    public function __construct(int $clientId, int $executiveId, string $dtEnd, $statusActive = 'new')
    {
        $statusConst = 'self::STATUS_' . strtoupper($statusActive);
        if (!defined($statusConst)) {
            throw new ErrorHandler('Такого статуса не существует', __DIR__, 63);
        };

        $this->clientId = $clientId;
        $this->executiveId = $executiveId;
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
        $actions = [self::ACTION_REPLY, self::ACTION_COMPLETE, self::ACTION_CANCEL, self::ACTION_REFUSE, self::ACTION_APPOINT];
        return $actions;
    }

    /** Возвращает список статусов
     *
     * @return array
     */
    public function getStatuses(): array
    {
        $statuses = [self::STATUS_NEW, self::STATUS_COMPLETED, self::STATUS_CANCELLED, self::STATUS_FAILED, self::STATUS_IN_PROGRESS];
        return $statuses;
    }

    /** Возвращает статус, в который перейдет задача для указанного действия
     *
     * @param string $actionClassName - название класса действия
     * @return string $statusNew
     */
    public function ifAction(string $actionClassName): string
    {
        $connections = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_REFUSE => self::STATUS_FAILED,
            self::ACTION_APPOINT => self::STATUS_IN_PROGRESS,
            self::ACTION_REPLY => $this->statusActive
        ];
        $statusNew = null;
        if (array_key_exists($actionClassName, $connections)) {
            $statusNew = $connections[$actionClassName];
        }
        return $statusNew;
    }

    /**
     *
     * @param string $role роль пользователя
     * @param int $userId
     * @return array $openActions список из названий классов действий
     */
    public function getOpenActions(string $role, int $userId): array
    {
        $openActions = [];
        if ($role === 'client' && $userId === $this->clientId) {
            if ($this->statusActive === self::STATUS_NEW ) {
                $openActions = [
                    self::ACTION_APPOINT,
                    self::ACTION_CANCEL
                ];
            } elseif ($this->statusActive === self::STATUS_IN_PROGRESS) {
                $openActions = [
                    self::ACTION_COMPLETE
                ];
            }
        } elseif ($role === 'executive' && $userId === $this->executiveId) {
            if ($this->statusActive === self::STATUS_NEW) {
                $openActions = [
                    self::ACTION_REPLY
                ];
            } elseif ($this->statusActive === self::STATUS_IN_PROGRESS) {
                $openActions = [
                    self::ACTION_REFUSE
                ];
            }
        }

        return $openActions;
    }
}


