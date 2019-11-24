<?php
use \Htmlacademy\Logic\AvailableActions;
require_once('vendor/autoload.php');

$task = new AvailableActions(78, 54, '30-12-2019', 'in progress');

echo 'Метод getActions: ';
var_dump($task->getActions());
echo 'Метод getStatuses: ';
var_dump($task->getStatuses());

assert($task->getOpenActions('executive', 54) === ['refuse']);
assert($task->getOpenActions('executive', 58) === []);
assert($task->getOpenActions('client', 78) === ['complete']);
assert($task->getOpenActions('client', 54) === []);

assert($task->ifAction('Htmlacademy\Logic\ReplyAction') === $task->statusActive);
assert($task->ifAction(Htmlacademy\Logic\CompleteAction::class) === 'completed');
assert($task->ifAction(Htmlacademy\Logic\CancelAction::class) === 'cancelled');
assert($task->ifAction(Htmlacademy\Logic\RefuseAction::class) === 'failed');
assert($task->ifAction(Htmlacademy\Logic\AppointAction::class) === 'in progress');
assert($task->ifAction('') === null);
















