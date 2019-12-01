<?php
use \Htmlacademy\Logic\AvailableActions;
use \Htmlacademy\ErrorHandlers\ErrorHandler;
use \Htmlacademy\Logic\Task;
require_once('D:\HTML_academy\OSPanel\domains\1101403-task-force-1\vendor\autoload.php');

try {
    $action = new AvailableActions();
}
catch (ErrorHandler $e) {
    echo 'Ошибка: ' . $e->getMessage() . '. ';
}
$task = new Task(63, 8, '30-12-2019');

assert($action->getOpenActions($task,'client', 63) === ['Htmlacademy\Logic\AppointAction','Htmlacademy\Logic\CancelAction']);
assert($action->getOpenActions($task,'client', 5) === []);
assert($action->getOpenActions($task,'executive', 8) === ['Htmlacademy\Logic\ReplyAction']);
assert($action->getOpenActions($task,'executive', 16) === []);
