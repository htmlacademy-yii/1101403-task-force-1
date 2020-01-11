<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class SourceInvalid extends \Exception
{
    /**
     * SourceInvalid constructor. Передает в родительский класс сообщение по умолчанию.
     * @param $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Источник файла неверный. ', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
