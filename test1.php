<?php
use \Htmlacademy\Logic\AvailableActions;
use \Htmlacademy\ErrorHandlers\ErrorHandler;
require_once('vendor/autoload.php');

try {
    $task = new AvailableActions(78, 54, '30-12-2019', 'in progress');
}
catch (ErrorHandler $exception) {

}

echo 'Метод getActions: ';
var_dump($task->getActions());
echo 'Метод getStatuses: ';
var_dump($task->getStatuses());


assert($task->getOpenActions('executive', 54) === ['Htmlacademy\Logic\RefuseAction']);
assert($task->getOpenActions('executive', 58) === []);
assert($task->getOpenActions('client', 78) === ['Htmlacademy\Logic\CompleteAction']);
assert($task->getOpenActions('client', 54) === []);

assert($task->ifAction('Htmlacademy\Logic\ReplyAction') === $task->statusActive);
assert($task->ifAction('Htmlacademy\Logic\CompleteAction') === 'completed');
assert($task->ifAction('Htmlacademy\Logic\CancelAction') === 'cancelled');
assert($task->ifAction('Htmlacademy\Logic\RefuseAction') === 'failed');
assert($task->ifAction('Htmlacademy\Logic\AppointAction') === 'in progress');
assert($task->ifAction('') === null);
















