<?php
use \Htmlacademy\Logic\AvailableActions;
use \Htmlacademy\ErrorHandlers\ErrorHandler;
use \Htmlacademy\Logic\Task;
require_once('vendor/autoload.php');

try {
    $action = new AvailableActions('in progress');
}
catch (ErrorHandler $e) {
    echo 'Ошибка: ' . $e->getMessage();
}
$task = new Task(78, 54, '30-12-2019');

/**
 * 78, 54, '30-12-2019', 'in progress'
 */
echo 'Метод getActions: ';
var_dump($action->getActions());
echo 'Метод getStatuses: ';
var_dump($action->getStatuses());


assert($action->getOpenActions($task,'executive',54) === ['Htmlacademy\Logic\RefuseAction']);
assert($action->getOpenActions($task,'executive',58) === []);
assert($action->getOpenActions($task,'client', 78) === ['Htmlacademy\Logic\CompleteAction']);
assert($action->getOpenActions($task,'client', 54) === []);

assert($action->ifAction('Htmlacademy\Logic\ReplyAction') === $action->statusActive);
assert($action->ifAction('Htmlacademy\Logic\CompleteAction') === 'completed');
assert($action->ifAction('Htmlacademy\Logic\CancelAction') === 'cancelled');
assert($action->ifAction('Htmlacademy\Logic\RefuseAction') === 'failed');
assert($action->ifAction('Htmlacademy\Logic\AppointAction') === 'in progress');


try {
    $action->getOpenActions($task, 'customer', 54);
}
catch (ErrorHandler $e) {
    echo 'Ошибка: ' . $e->getMessage() . '. ';
}

try {
    $action->ifAction('');
}
catch (ErrorHandler $e){
    echo 'Ошибка: ' . $e->getMessage() . '. ';
}

try {
    $action = new AvailableActions('invisible');
}
catch (ErrorHandler $e) {
    echo 'Ошибка: ' . $e->getMessage() . ', файл: ' . $e->getFilePath() . ', строка: ' . $e->getStringNumber() . ' ';
}
















