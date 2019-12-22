<?php

use Htmlacademy\Logic\CSVReader;
use Htmlacademy\Logic\SQLwriter;
use Htmlacademy\MyExceptions\ConnectionInvalid;
use Htmlacademy\MyExceptions\FileFormatInvalid;

require_once('vendor/autoload.php');

$filesOrder = [
    'categories' => [],
    'cities' => [],
    'stop_words' => [],
    'users' => [
        0 => 'cities'
    ],
    'tasks' => [
        0 => 'users',
        1 => 'users',
        2 => 'categories',
        3 => 'cities'
    ],
    'reviews' => [
        0 => 'users',
        1 => 'users',
        2 => 'tasks'
    ],
    'users_specialisations' => [
        0 => 'users',
        1 => 'categories'
    ],
    'task_replies' => [
        0 => 'users',
        1 => 'tasks'
    ],
    'alerts' => [
        0 => 'users',
        1 => 'tasks'
    ],
    'clients_favorites_executors' => [
        0 => 'users',
        1 => 'users'
    ]
];
$ids = [
    'categories' => [],
    'cities' => [],
    'stop_words' => [],
    'users' => [],
    'tasks' => [],
    'reviews' => [],
    'users_specialisations' => [],
    'task_replies' => [],
    'alerts' => [],
    'clients_favorites_executors' => []
];

foreach ($filesOrder as $file => $fks) {
    if (!empty($fks)) {
        foreach ($fks as $fk) {
            $fk = $ids[$fk];
        }
    }
    $path = 'D:\HTML_academy\OSPanel\domains\1101403-task-force-1\data_mine\\' . $file . '.csv';

    try {
        $csvReader = new CSVReader($path);
    }
    catch (FileFormatInvalid $f) {
        echo 'Ошибка: ' . $f->getMessage() . '. ';
    }
    try {
        $sqlWriter = new SQLwriter($path, '127.0.0.1', 'root', '', 'taskforce');
    }
    catch (ConnectionInvalid $e) {
        echo 'Ошибка: ' . $e->getMessage() . '. ';
    }
    $fileNew = new SplFileObject($sqlWriter->getNewFileName(), 'w') or die('Невозможно открыть файл!');
    $sqlWriter->add2Request($csvReader->getHeaders(), $csvReader->getContent(), []);
    $fileNew->fwrite($sqlWriter->getSqlCode());

    $ids[$file] = $sqlWriter->getIds();
}
