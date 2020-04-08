<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\SearchUsersForm;
use frontend\models\Users;
use Yii;
use yii\db\Query;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex($sort = 'dt_reg')
    {
        $request = Users::find()
            ->where(['role' => 'executive'])
            ->with(['executivesTasks', 'reviewsByExecutive', 'usersSpecialisations'])
            ->groupBy('users.id');
        if ($sort === 'order_count') {
            $request = $request
                ->select('users.*, COUNT(tasks.id) AS order_count')
                ->joinWith('executivesTasks');
        } elseif ($sort === 'rating') {
            $request = $request
                ->select('users.*, AVG(reviews.rate) AS rating')
                ->joinWith('reviewsByExecutive');
        }
        $request = $request->orderBy([$sort => SORT_DESC]);

        // Достаю существующие категории из БД и преобразовываю в массив ['id' => 'title']
        $categories = Categories::find()->all();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->id] = $category->title;
        }
        $categories = $result;
        $model = new SearchUsersForm();
        //фильтры
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->categories) {
                $request = $request
                    ->joinWith('usersSpecialisations')
                    ->andWhere(['users_specialisations.cat_id' => $model->categories]);
            }
            if ($model->freeNow) {
                $request = $request
                    ->joinWith('executivesTasks')
                    ->andWhere(['tasks.id' => null]);
            }
            if ($model->online) {
                $halfAnHourAgo = date('Y-m-d H:i:s', strtotime('-30 mins'));
                $request = $request->andFilterCompare('users.dt_last_visit', ">$halfAnHourAgo");
            }
            if ($model->hasReplies) {
                $request = $request
                    ->joinWith('reviewsByExecutive')
                    ->andWhere(['not', ['reviews.comment' => null]]);
            }
            if ($model->inFavorites) {
                $request = $request
                    ->joinWith('recordsInFavorites')
                    ->andWhere(['not', ['clients_favorites_executors.id' => null]]);
            }
            if ($model->name) {
                $request = $request->andWhere('MATCH(name) AGAINST (:name)', [':name' => $model->name]);
            }

        }

        $users = $request->all();
        // получаю массив id пользователей
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }

        //рассчитываю рейтинг, количество заданий и отзывов для каждого юзера
        $usersInfo = $this->addInfo($userIds);

        //передаю все в представление
        return $this->render('index', ['users' => $users, 'categories' => $categories, 'model' => $model, 'usersInfo' => $usersInfo]);
    }

    /**
     * Метод рассчитывает и записывает в модели рейтинг юзеров
     * @param array $userIds - массив с id юзеров, которым надо рассчитать рейтинг, количество заданий и количество отзывов
     * @return array $usersInfo массив вида [id => ['rating' => 5, 'reviews' => 4, 'tasks' => 0],[...]] с данными о юзере
     */
    protected function addInfo(array $userIds): array
    {
        $usersInfo = [];
        foreach ($userIds as $id) {
            $usersInfo[$id] = ['rating' => 0, 'reviews' => 0, 'tasks' => 0];
        }
        $reviewQuery = new Query();
        $ratingAndReviews = $reviewQuery
            ->select(["executive_id AS id", "ROUND(AVG(rate),1) AS rating", "COUNT(comment) AS reviews"])
            ->from(['reviews'])
            ->where(['executive_id' => $userIds])
            ->groupBy('executive_id')
            ->all();

        foreach ($ratingAndReviews as $info) {
            if (in_array(intval($info['id']), $userIds)) {
                $usersInfo[$info['id']]['rating'] = $info['rating'] ?: 0;
                $usersInfo[$info['id']]['reviews'] = $info['reviews'] ?: 0;
            }
        }
        $tasksQuery = new Query();
        $tasks = $tasksQuery
            ->select(["executive_id AS id", "COUNT(id) AS count"])
            ->from('tasks')
            ->where(['executive_id' => $userIds])
            ->groupBy('executive_id')
            ->all();

        foreach ($tasks as $task) {
            if (in_array(intval($task['id']), $userIds)) {
                $usersInfo[$task['id']]['tasks'] = $task['count'] ?: 0;
            }
        }

        return $usersInfo;
    }

}
