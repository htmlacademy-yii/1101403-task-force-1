<?php
namespace Htmlacademy\Logic;
use Htmlacademy\MyExceptions\RoleInvalid;
use Htmlacademy\MyExceptions\ActionInvalid;

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
     * Возвращает список действий
     *
     * @return array $actions
     */
    static function getActions(): array
    {
        $actions = [self::ACTION_REPLY, self::ACTION_COMPLETE, self::ACTION_CANCEL, self::ACTION_REFUSE, self::ACTION_APPOINT];
        return $actions;
    }

    /**
     * Возвращает список статусов
     *
     * @return array
     */
    static function getStatuses(): array
    {
        $statuses = [self::STATUS_NEW, self::STATUS_COMPLETED, self::STATUS_CANCELLED, self::STATUS_FAILED, self::STATUS_IN_PROGRESS];
        return $statuses;
    }

    /**
     * Возвращает список ролей
     *
     * @return array
     */
    static function getRoles(): array
    {
        $roles = [self::ROLE_CLIENT, self::ROLE_EXECUTIVE];
        return $roles;
    }

    /**
     * Возвращает статус, в который перейдет задача для указанного действия
     *
     * @param Task $task - объект класса Task
     * @param string $actionClassName - название класса действия
     * @return string $statusNew
     */
    public function ifAction(Task $task, string $actionClassName): string
    {
        if (!in_array($actionClassName, $this->getActions())) {
            throw new ActionInvalid();
        }
        $connections = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_REFUSE => self::STATUS_FAILED,
            self::ACTION_APPOINT => self::STATUS_IN_PROGRESS,
            self::ACTION_REPLY => $task->getstatus()
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
     * @param Task $task - объект задачи
     * @return array $openActions список из названий доступных классов действий
     */
    public function getOpenActions(Task $task, string $role, int $userId): array
    {
        if (!in_array($role, $this->getRoles())) {
            throw new RoleInvalid();
        }
        $openActions = [];
        if ($role === 'client' && $userId === $task->getClientId()) {
            if ($task->getStatus() === self::STATUS_NEW ) {
                $openActions = [
                    self::ACTION_APPOINT,
                    self::ACTION_CANCEL
                ];
            } elseif ($task->getStatus() === self::STATUS_IN_PROGRESS) {
                $openActions = [
                    self::ACTION_COMPLETE
                ];
            }
        } elseif ($role === 'executive' && $userId === $task->getExecutiveId()) {
            if ($task->getStatus() === self::STATUS_NEW) {
                $openActions = [
                    self::ACTION_REPLY
                ];
            } elseif ($task->getStatus() === self::STATUS_IN_PROGRESS) {
                $openActions = [
                    self::ACTION_REFUSE
                ];
            }
        }

        return $openActions;
    }
}


