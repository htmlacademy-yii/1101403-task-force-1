<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class SourceInvalid extends \Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
