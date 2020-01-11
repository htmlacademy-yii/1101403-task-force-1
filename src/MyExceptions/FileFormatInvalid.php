<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class FileFormatInvalid extends \Exception
{
    /**
     * FileFormatInvalid constructor. Передает в родительский класс сообщение по умолчанию.
     * @param $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Ошибка формата файла', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
