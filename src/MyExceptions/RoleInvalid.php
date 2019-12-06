<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class RoleInvalid extends \Exception
{
    public function __construct($message = 'Такой роли не существует', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
