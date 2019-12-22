<?php
namespace Htmlacademy\MyExceptions;
use Throwable;

class ConnectionInvalid extends \Exception
{
    /**
     * ConnectionInvalid constructor. Передает в родительский класс сообщение по умолчанию.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Не удалось установить соединение', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
