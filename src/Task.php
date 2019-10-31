<?php

class Task
{
    // Константы:
    const ACTIONS = [
        'answer' => null,
        'finish' => ['finished'],
        'cancel' => ['cancelled'],
        'refuse' => ['failed'],
        'appoint' => ['in progress']
    ];
    const STATUSES = ['new', 'in progress', 'cancelled', 'failed', 'completed'];
    const ROLES = ['client', 'executive'];

    // Свойства для хранения:
    public $idClient = null;
    public $idExecutive = null;
    public $dtEnd = null;
    public $statusActive = null;

    // Конструктор класса
    public function __construct($idClient, $idExecutive, $dtEnd, $statusActive)
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
        $actions = array_keys($this->ACTIONS);
        return $actions;
    }

    /** Возвращает список статусов
     *
     * @return array
     */
    public function showStatuses(): array
    {
        return $this->STATUSES;
    }

    /** Возвращает статус, в который перейдет задача для указанного действия
     *
     * @param string $action - действие
     * @return string|null $statusNew
    */
    public function ifAction(string $action):? string
    {
        if (isset($this->ACTIONS[$action])) {
            if ($this->ACTIONS[$action] === null) {
                $statusNew = $this->statusActive;
            } else {
                $statusNew = $this->ACTIONS[$action];
            }
        } else {
            $statusNew = null;
        }
        return $statusNew;
    }

}
