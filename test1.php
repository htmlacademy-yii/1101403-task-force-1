<?php
use \Htmlacademy\Task;
require_once('vendor/autoload.php');

$task = new Task(78, 54, '30-12-2019');

assert($task->ifAction('answer') === $task->statusActive);
assert($task->ifAction('complete') === 'completed');
assert($task->ifAction('cancel') === 'cancelled');
assert($task->ifAction('refuse') === 'failed');
assert($task->ifAction('appoint') === 'in progress');
assert($task->ifAction('') === $task->statusActive);

echo 'Метод showActions: ';
var_dump($task->showActions());
echo 'Метод showStatuses: ';
var_dump($task->showStatuses());








