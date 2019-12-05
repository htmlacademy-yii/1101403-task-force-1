<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class StatusInvalid extends \Exception
{
    public function __construct($message = 'Такого статуса не существует', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
