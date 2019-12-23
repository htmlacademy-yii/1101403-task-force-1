<?php
namespace Htmlacademy\Logic;

use Htmlacademy\MyExceptions\FileFormatInvalid;

class CSVReader
{
    /**
     * @var $filePath - путь к файлу CSV
     */
    private $filePath;

    /**
     * @var - экземпляр класса \SplFileObject
     */
    private $file;

    /**
     * @var array массив с заголовками
     */
    private $headers;

    /**
     * CSVReader конструктор.
     * @param $filePath - путь к файлу
     * @throws FileFormatInvalid
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->file = new \SplFileObject($this->filePath, 'r');
        $this->headers = $this->getHeaderData();
        if (!$this->getHeaderData()) {
            throw new FileFormatInvalid('Заголовки полей заданы неверно');
        }
    }

    /**
     * Метод извлекает заголовки из файла CSV
     * @return array массив с заголовками
     */
    protected function getHeaderData(): array
    {
        $this->file->rewind();
        $headers = $this->file->fgetcsv();

        return $headers;
    }

    /**
     * Метод извлекает массив со следующей строкой файла CSV, если файл не подошел к концу
     * @return array массив данных следующей строки, если файл не подошел к концу
     */
    protected function getNextLine()
    {
        if (!$this->file->eof()) {
            return $this->file->fgetcsv();
        }
    }

    /**
     * Метод возвращает двумерный массив с содержимым файла CSV
     * @return array - двумерный массив вида [[массив_строки_1],[массив_строки_2],...].
     */
    public function getContent()
    {
        $content = [];
        $this->file->rewind();
        $this->file->next();
        while($line = $this->getNextLine()) {
            $content[] = $line;
        }
        return $content;
    }

    /**
     * Метод возвращает заголовки файла CSV
     * @return array - массив с заголовками
     */
    public function getHeaders()
    {
        return $this->headers;
    }


}
