<?php
namespace Htmlacademy\Logic;
use Htmlacademy\MyExceptions\StatusInvalid;


class Task
{
    /**
     * id заказчика
     * @var int
     */
    private $clientId;
    /**
     * id исполнителя
     * @var int
     */
    private $executiveId;
    /**
     * Дата окончания существования задания
     * @var string
     */
    private $dtEnd;
    /**
     * Статус задания
     * @var string
     */
    private $statusActive;

    /**
     * Конструктор класса Task
     * @param int $clientId
     * @param int $executiveId
     * @param string|null $dtEnd
     * @param string $statusActive
     * @throws StatusInvalid
     */
    public function __construct(int $clientId, int $executiveId, string $statusActive, string $dtEnd = null)
    {
        if (!in_array($statusActive, AvailableActions::getStatuses())) {
            throw new StatusInvalid();
        }
        $this->clientId = $clientId;
        $this->executiveId = $executiveId;
        $this->dtEnd = $dtEnd;
        $this->statusActive = $statusActive;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return int
     */
    public function getExecutiveId(): int
    {
        return $this->executiveId;
    }

    /**
     * @return string
     */
    public function getDtEnd(): string
    {
        return $this->dtEnd;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->statusActive;
    }

}
