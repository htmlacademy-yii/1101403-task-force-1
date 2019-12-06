<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class ActionInvalid extends \Exception
{
    public function __construct($message = 'Такого действия не существует', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
