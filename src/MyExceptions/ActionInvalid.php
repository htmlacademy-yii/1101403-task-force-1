<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class ActionInvalid extends \Exception
{
    /**
     * ActionInvalid constructor. Передает в родительский класс сообщение по умолчанию.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Такого действия не существует', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
