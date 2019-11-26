<?php
use \Htmlacademy\Logic\AvailableActions;
require_once('D:\HTML_academy\OSPanel\domains\1101403-task-force-1\vendor\autoload.php');

$task = new AvailableActions(63, 8, '30-12-2019');

assert($task->getOpenActions('client', 63) === ['appoint','cancel']);
assert($task->getOpenActions('client', 5) === []);
assert($task->getOpenActions('executive', 8) === ['reply']);
assert($task->getOpenActions('executive', 16) === []);
