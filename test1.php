<?php
use \Htmlacademy\Logic\Actions\AvailableActions;
use \Htmlacademy\MyExceptions\StatusInvalid;
use \Htmlacademy\MyExceptions\RoleInvalid;
use \Htmlacademy\MyExceptions\ActionInvalid;
use \Htmlacademy\Logic\Task;
use \Htmlacademy\Logic;
require_once('vendor/autoload.php');

$action = new AvailableActions();

try {
    $task = new Task(78, 54, 'in progress', '30-12-2019');
}
catch (StatusInvalid $e) {
    echo 'Ошибка: ' . $e->getMessage() . '. ';
}

echo 'Метод getActions: ';
var_dump($action->getActions());
echo 'Метод getStatuses: ';
var_dump($action->getStatuses());


assert($action->getOpenActions($task,'executive',54) === [Logic\Actions\RefuseAction::class]);
assert($action->getOpenActions($task,'executive',58) === []);
assert($action->getOpenActions($task,'client', 78) === [Logic\Actions\CompleteAction::class]);
assert($action->getOpenActions($task,'client', 54) === []);

assert($action->ifAction($task, Logic\Actions\ReplyAction::class) === $task->getStatus());
assert($action->ifAction($task, Logic\Actions\CompleteAction::class) === 'completed');
assert($action->ifAction($task, Logic\Actions\CancelAction::class) === 'cancelled');
assert($action->ifAction($task, Logic\Actions\RefuseAction::class) === 'failed');
assert($action->ifAction($task, Logic\ACtions\SubmitAction::class) === 'in progress');

try {
    $task2 = new Task(55, 68, 'at home', '31-12-2019');
}
catch (StatusInvalid $s) {
    echo 'Ошибка: ' . $s->getMessage() . ', файл: ' . $s->getFile() . ', строка: ' . $s->getLine() . '. ';
}

try {
    $action->getOpenActions($task, 'customer', 54);
}
catch (RoleInvalid $r) {
    echo 'Ошибка: ' . $r->getMessage() . '. ';
}

try {
    $action->ifAction($task, '');
}
catch (ActionInvalid $a){
    echo 'Ошибка: ' . $a->getMessage() . '. ';
}

















