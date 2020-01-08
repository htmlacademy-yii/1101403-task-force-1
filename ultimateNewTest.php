<?php

use Htmlacademy\Logic\CSVReader;
use Htmlacademy\Logic\IdChanger;
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

$ids = [];

foreach ($filesOrder as $fileName => $fks) {
    $path = __DIR__ . '\\data_mine\\' . $fileName .'.csv';
    $fileObject = new SplFileObject($path);
    try {
        $reader = new CSVReader($fileObject);
    }
    catch (FileFormatInvalid $f) {
        echo 'Ошибка: ' . $f->getMessage() . '. ';
    }

    $database = 'taskforce';
    $mysql = new mysqli('127.0.0.1', 'root','', $database);
    try {
        $writer = new SQLwriter($path, $mysql, $database);
    }
    catch (ConnectionInvalid $e) {
        echo 'Ошибка: ' . $e->getMessage() . '. ';
    }

    $content = $reader->getContent();

    if (!empty($fks)) {
        $checker = new IdChanger($content, $ids, $fks);
        $content = $checker->changeIds();
    }

    $fileNew = new SplFileObject($writer->getNewFileName(), 'w') or die('Невозможно открыть файл!');

    $writer->addToRequest($reader->getHeaders(), $content);
    $ids[$writer->getTableName()] = $writer->getIds();
    $fileNew->fwrite($writer->getSqlCode()) or die('Невозможно записать содержимое в файл!');
}
