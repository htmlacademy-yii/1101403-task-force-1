<?php
namespace Htmlacademy\ErrorHandlers;
use Throwable;

class ErrorHandler extends \Exception
{
    /**
     * Текст сообщения об ошибке
     * @var string $message
     */
    protected $message;
    /**
     * Путь к файлу, в котором было выкинуто исключение
     * @var string $filePath
     */
    protected $filePath;
    /**
     * Номер строки, где произошла ошибка
     * @var int $stringNumber
     */
    protected $stringNumber;

    public function __construct($message = "", string $filePath, int $stringNumber, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->filePath = $filePath;
        $this->stringNumber = $stringNumber;
    }

    /**
     * Возвращает номер строки с ошибкой
     * @return int
     */
    public function getStringNumber(): int
    {
        return $this->stringNumber;
    }

    /**
     * Возвращает путь к файлу с ошибкой
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
