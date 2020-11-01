<?php
namespace Htmlacademy\Logic\Actions;


use Htmlacademy\MyExceptions\StatusInvalid;
use Htmlacademy\MyExceptions\RoleInvalid;
use Htmlacademy\MyExceptions\ActionInvalid;
use Yii;

class AvailableActions
{
    /**
     * Константы возможных действий
     */
    const ACTION_RESPONSE = ResponseAction::class;
    const ACTION_COMPLETE = CompleteAction::class;
    const ACTION_CANCEL = CancelAction::class;
    const ACTION_REFUSE = RefuseAction::class;
    const ACTION_SUBMIT = SubmitAction::class;

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
    public static function getActions(): array
    {
        return [self::ACTION_RESPONSE, self::ACTION_COMPLETE, self::ACTION_CANCEL, self::ACTION_REFUSE, self::ACTION_SUBMIT];
    }

    /**
     * Возвращает список статусов
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [self::STATUS_NEW, self::STATUS_COMPLETED, self::STATUS_CANCELLED, self::STATUS_FAILED, self::STATUS_IN_PROGRESS];
    }

    /**
     * Возвращает список ролей
     *
     * @return array
     */
    public static function getRoles(): array
    {
        return [self::ROLE_CLIENT, self::ROLE_EXECUTIVE];
    }

    /**
     * Возвращает статус, в который перейдет задача для указанного действия
     *
     * @param string $status - статус задания
     * @param string $actionClassName - название класса действия
     * @return string $statusNew
     * @throws ActionInvalid
     * @throws StatusInvalid
     */
    public static function ifAction(string $status, string $actionClassName): string
    {
        if (!in_array($actionClassName, self::getActions())) {
            throw new ActionInvalid();
        } elseif (!in_array($status, self::getStatuses())) {
            throw new StatusInvalid();
        }
        $connections = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_REFUSE => self::STATUS_FAILED,
            self::ACTION_SUBMIT => self::STATUS_IN_PROGRESS,
            self::ACTION_RESPONSE => $status
        ];
        $statusNew = null;
        if (array_key_exists($actionClassName, $connections)) {
            $statusNew = $connections[$actionClassName];
        }
        return $statusNew;
    }

    /**
     *
     * @param string $role
     * @param int $userId
     * @param int $clientId
     * @param int $executiveId
     * @return array $openActions список из названий доступных классов действий
     * @throws RoleInvalid
     */
    public static function getOpenActions(string $role, int $userId, int $clientId, int $executiveId): array
    {
        if (!in_array($role, self::getRoles())) {
            throw new RoleInvalid();
        }

        $openActions = [];
        foreach (self::getActions() as $action) {
            if ($action::isPermitted($userId, $clientId, $executiveId)) {
                $actions[] = $action;
            }
        }

        return $openActions;
    }

    /**
     * @param int $clientId
     * @param string $replyStatus
     * @param string $taskStatus
     * @return bool
     */
    public static function isHiddenSubmitForm(int $clientId, string $replyStatus, string $taskStatus): bool
    {
        if ($clientId === Yii::$app->user->getId() && $replyStatus === 'new' && $taskStatus === 'new') {
            return true;
        }
        return false;
    }
}


