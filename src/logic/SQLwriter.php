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
    public function addToRequest(array $headers, array $content): array
    {
        $ids =[];
        $id = 0;
        foreach ($headers as $header) {
            $this->mysql->real_escape_string($header);
        }
        foreach ($content as $line) {
            $limit = count($headers);
            $lastTurn = $limit - 1;
            if ($limit === count($line)) {
                $id++;
                $ids[] = $id;
                $this->request .= "INSERT INTO " . $this->tableName . " SET id = " . $id . ", ";
                for ($i = 0; $i < $limit; $i++) {
                    $this->mysql->real_escape_string($headers[$i]);
                    $this->mysql->real_escape_string($line[$i]);
                    if ($headers[$i] === 'password') {
                        $this->request .= " " . $headers[$i] . " = " . password_hash($line[$i], PASSWORD_DEFAULT);
                    } else {
                        $this->request .= " " . $headers[$i] . " = " . $line[$i];
                    }
                    if ($i !== $lastTurn) {
                        $this->request .= ", ";
                    }
                }
                $this->request .= " ;\r\n";
            }
        }

        return $ids;
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
     * Метод возвращает массив с названием обрабатываемой таблицы
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }
}
