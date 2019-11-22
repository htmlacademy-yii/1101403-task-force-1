<?php
use \Htmlacademy\Logic\AvailableActions;
require_once('vendor/autoload.php');

$task = new AvailableActions(78, 54, '30-12-2019');

echo 'Метод getActions: ';
var_dump($task->getActions());
echo 'Метод getStatuses: ';
var_dump($task->getStatuses());

assert($task->ifAction('answer') === $task->statusActive);
assert($task->ifAction('complete') === 'completed');
assert($task->ifAction('cancel') === 'cancelled');
assert($task->ifAction('refuse') === 'failed');
assert($task->ifAction('appoint') === 'in progress');
assert($task->ifAction('') === null);










