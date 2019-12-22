<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class RoleInvalid extends \Exception
{
    /**
     * RoleInvalid constructor. Передает в родительский класс сообщение по умолчанию.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Такой роли не существует', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
