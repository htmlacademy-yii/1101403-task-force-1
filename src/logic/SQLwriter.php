<?php
namespace Htmlacademy\Logic;

use Htmlacademy\MyExceptions\ConnectionInvalid;

class SQLwriter
{
    /**
     * @var $filePath - путь к файлу
     */
    private $filePath;

    /**
     * @var string текст команд БД
     */
    private $request;

    /**
     * @var string название таблицы, для которой пишутся команды
     */
    private $tableName;

    /**
     * @var - массив с id данных, которые создаются в экземпляре класса
     */
    private $ids;

    /**
     * @var - объект класса \mysqli для соединения с БД
     */
    private $mysql;

    /**
     * SQLwriter constructor.
     * @param $filePath - путь к файлу
     * @param $mysql - пароль для подключения к хосту
     * @param $dataBase - название базы данных
     * @throws ConnectionInvalid - исключение для плохого соединения
     */
    public function __construct(string $filePath, $mysql, string $dataBase)
    {
        $this->filePath = $filePath;
        $this->mysql = $mysql;
        if (!$this->mysql) {
            throw new ConnectionInvalid('Не удалось подключиться к БД, проверьте данные подключения');
        }
        $this->mysql->set_charset('utf8');

        $this->request = "USE " . $this->mysql->real_escape_string($dataBase) . ";\r\n";
        $this->tableName = $this->mysql->real_escape_string(basename($this->filePath,'.csv'));
    }

    /**
     * Возвращает название для нового файла SQL
     * @return string
     */
    public function getNewFileName(): string
    {
        return $this->tableName . '.sql';
    }

    /**
     * Метод создает команды SQL из содержимого массива $content и добавляет их в текст запроса
     * @param array $headers
     * @param array $content - двумерный массив с массивами из содержимого полей вида [[массив_строки_1],[массив_строки_2],...]
     */
    public function addToRequest(array $headers, array $content)
    {
        $id = 0;
        foreach ($headers as $header) {
            $this->mysql->real_escape_string($header);
        }
        foreach ($content as $line) {
            if (count($headers) === count($line)) {
                $id++;
                $this->ids[] = $id;
                foreach ($headers as $header) {
                    $this->mysql->real_escape_string($header);
                }
                foreach ($line as $value) {
                    $this->mysql->real_escape_string($value);
                }
                $this->request .= "INSERT INTO " . $this->tableName . " (id, " . implode(", ", $headers) . ") VALUES (" . $id . ", '" . implode("', '", $line) . "' );\r\n";
            }
        }
    }

    /**
     * Метод возвращает текст команд SQL, созданных из массива данных
     * !ВНИМАНИЕ Если вы не использовали метод add2Request, то вернется только текст конструктора
     * @return string
     */
    public function getSqlCode(): string
    {
        return $this->request;
    }

    /**
     * Метод возвращает массив с id записей из обрабатываемой таблицы
     * @return mixed
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Метод возвращает массив с названием обрабатываемой таблицы
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }
}
