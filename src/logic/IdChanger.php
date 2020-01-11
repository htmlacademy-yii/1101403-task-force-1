<?php
namespace Htmlacademy\Logic;

class IdChanger
{
    /**
     * @var array $content
     */
    private $content;

    /**
     * @var array $ids
     * массив id вида [название_таблицы => [1,2,3,4 etc.], etc.]
     */
    private $ids;

    /**
     * @var array $fks
     * массив зависимости положения элементов внешних ключей и названия таблицы вида [[индекс_элемента_с_внешним_ключом => название_таблицы],etc.]
     */
    private $fks;

    /**
     * IdChecker constructor.
     * @param $content
     * @param $ids
     * @param $fks
     */
    public function __construct($content, $ids, $fks)
    {
        $this->ids = $ids;
        $this->content = $content;
        $this->fks = $fks;
    }

    /**
     * Метод вставляет случайные значения из списка реальных id
     * @return array
     */
    public function changeIds()
    {
        foreach ($this->content as $key => $line) {
            foreach ($line as $i => $value) {
                if (array_key_exists($i, $this->fks)) {
                    $currentIds = $this->ids[$this->fks[$i]];
                    $this->content[$key][$i] =  $currentIds[array_rand($currentIds)];
                }
            }
        }
        return $this->content;
    }


}
