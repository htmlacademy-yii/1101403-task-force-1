<?php
namespace Htmlacademy\Logic;

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
     * Конструктор класса Task.
     * @param int $clientId
     * @param int $executiveId
     * @param string|null $dtEnd
     */
    public function __construct(int $clientId, int $executiveId, string $dtEnd = null)
    {
        $this->clientId = $clientId;
        $this->executiveId = $executiveId;
        $this->dtEnd = $dtEnd;
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

}
