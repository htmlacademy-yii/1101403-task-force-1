<?php


namespace Htmlacademy\logic;

use yii\db\Query;

/**
 * Class ExecutivesInfo рассчитывает рейтинг, количество заданий, отзывов
 * @package Htmlacademy\logic
 */
class ExecutivesInfo
{
    /**
     * @var array массив с int id исполнителей, для которых необходимо рассчитать информацию
     */
    protected $ids = [];

    /**
     * ExecutivesInfo constructor.
     * @param array $ids
     */
    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * метод средствами mysql рассчитывает рейтинг исполнителей
     * @return array возвращает массив вида [uid1 => rating1, uid2 => rating2 ...]
     */
    public function getRating(): array
    {
        $ratings = [];
        foreach ($this->ids as $id) {
            $ratings[$id] = 0;
        }
        $ratingQuery = new Query();
        $result = $ratingQuery
            ->select(["executive_id AS id", "ROUND(AVG(rate),1) AS rate"])
            ->from(['reviews'])
            ->where(['executive_id' => $this->ids])
            ->groupBy('executive_id')
            ->all();
        foreach ($result as $rating) {
            if (in_array(intval($rating['id']), $this->ids)) {
                $ratings[$rating['id']] = $rating['rate'] ?: 0;
            }
        }

        return $ratings;
    }

    /**
     * метод средствами mysql рассчитывает количество отзывов у исполнителей
     * @return array возвращает массив вида [uid1 => reviewCount1, uid2 => reviewCount2 ...]
     */
    public function getReviews(): array
    {
        $reviews = [];
        foreach ($this->ids as $id) {
            $reviews[$id] = 0;
        }
        $reviewsQuery = new Query();
        $result = $reviewsQuery
            ->select(["executive_id AS id", "COUNT(comment) AS reviews"])
            ->from(['reviews'])
            ->where(['executive_id' => $this->ids])
            ->groupBy('executive_id')
            ->all();
        foreach ($result as $review) {
            if (in_array(intval($review['id']), $this->ids)) {
                $reviews[$review['id']] = $review['reviews'] ?: 0;
            }
        }

        return $reviews;
    }

    /**
     * метод средствами mysql рассчитывает количество заданий у исполнителей
     * @return array возвращает массив вида [uid1 => taskCount1, uid2 => taskCount2 ...]
     */
    public function getTasks()
    {
        $tasks = [];
        foreach ($this->ids as $id) {
            $tasks[$id] = 0;
        }
        $tasksQuery = new Query();
        $result = $tasksQuery
            ->select(["executive_id AS id", "COUNT(id) AS count"])
            ->from('tasks')
            ->where(['executive_id' => $this->ids])
            ->groupBy('executive_id')
            ->all();
        foreach ($result as $task) {
            if (in_array(intval($task['id']), $this->ids)) {
                $tasks[$task['id']] = $task['count'] ?: 0;
            }
        }

        return $tasks;
    }

}
