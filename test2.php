<?php
use \Htmlacademy\Logic\AvailableActions;
use \Htmlacademy\MyExceptions\StatusInvalid;
use \Htmlacademy\MyExceptions\RoleInvalid;
use \Htmlacademy\MyExceptions\ActionInvalid;
use \Htmlacademy\Logic\Task;
use \Htmlacademy\Logic;
require_once('vendor/autoload.php');


$action = new AvailableActions();

try {
    $task = new Task(63, 8, 'new', '30-12-2019');
}
catch (StatusInvalid $s) {
    echo 'Ошибка: ' . $s->getMessage();
}

assert($action->getOpenActions($task,'client', 63) === [Logic\AppointAction::class, Logic\CancelAction::class]);
assert($action->getOpenActions($task,'client', 5) === []);
assert($action->getOpenActions($task,'executive', 8) === [Logic\ReplyAction::class]);
assert($action->getOpenActions($task,'executive', 16) === []);

try {
    $action->getOpenActions($task, 'courier', 67);
}
catch (RoleInvalid $r) {
    echo 'Ошибка: ' . $r->getMessage() . '. ';
}

try {
    $action->ifAction($task, 'Introduce');
}
catch (ActionInvalid $a) {
    echo 'Ошибка: ' . $a->getMessage() . '. ';
}
