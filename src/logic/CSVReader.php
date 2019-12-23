<?php
namespace Htmlacademy\Logic;

use Htmlacademy\MyExceptions\FileFormatInvalid;

class CSVReader
{
    /**
     * @var - экземпляр класса \SplFileObject
     */
    private $file;

    /**
     * @var array массив с заголовками
     */
    private $headers;

    /**
     * @var
     */
    private $scndLinePosition;

    /**
     * CSVReader конструктор.
     * @param $file - экземпляр класса \SplFileObject в режиме 'r'
     * @throws FileFormatInvalid
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->headers = $this->getHeaderData();
        if (!$this->headers) {
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
        $this->scndLinePosition = $this->file->ftell();
        $this->file->rewind();

        return $headers;
    }

    /**
     * Метод извлекает массив со следующей строкой файла CSV, если файл не подошел к концу
     * @return array|bool массив данных следующей строки, если файл не подошел к концу
     */
    protected function getNextLine()
    {
        if ($this->file->valid()) {
            $result = $this->file->fgetcsv();
            return $result;
        }
        return false;
    }

    /**
     * Метод возвращает двумерный массив с содержимым файла CSV
     * @return array - двумерный массив вида [[массив_строки_1],[массив_строки_2],...].
     */
    public function getContent()
    {
        $content = [];
        $this->file->fseek($this->scndLinePosition);
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
