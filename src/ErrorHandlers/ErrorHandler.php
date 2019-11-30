<?php
namespace Htmlacademy\ErrorHandlers;

use Throwable;

class ErrorHandler extends \Exception
{
    /**
     * Текст сообщения об ошибке
     * @var string $message
     */
    private $message;
    /**
     * Путь к файлу, в котором было выкинуто исключение
     * @var string $filePath
     */
    private $filePath;
    /**
     * Номер строки, где произошла ошибка
     * @var int $stringNumber
     */
    private $stringNumber;

    public function __construct($message = "", $filePath, $stringNumber, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->filePath = $filePath;
        $this->stringNumber = $stringNumber;
    }

    /**
     * Возвращает номер строки с ошибкой
     * @return int
     */
    public function getStringNumber()
    {
        return $this->stringNumber;
    }

    /**
     * Возвращает путь к файлу с ошибкой
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }
}
