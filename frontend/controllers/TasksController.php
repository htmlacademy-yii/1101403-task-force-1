<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\SearchTaskForm;
use Yii;
use yii\web\Controller;
use frontend\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex($curPage = 1)
    {
        $request = Tasks::find()
            ->where(['status' => 'new'])
            ->with(['category','city'])
            ->orderBy(['tasks.dt_create' => SORT_DESC]);
        // Достаю существующие категории из БД и преобразовываю в массив ['id' => 'title']
        $categories = Categories::find()->all();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->id] = $category->title;
        }
        $categories = $result;
        $model = new SearchTaskForm();
        //фильтры
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->categories) {
                $request = $request->andWhere(['cat_id' => $model->categories]);
            }
            if ($model->isRepliesExist) {
                $request = $request
                    ->joinWith('taskReplies')
                    ->andWhere(['task_replies.id' => null]);
            }
            if ($model->remoteWorking) {
                $request = $request->andWhere(['city_id' => null]);
            }
            if ($model->chosenPeriod === 'day') {
                $today = date('Y-m-d H:i:s', strtotime('today'));
                $request = $request->andFilterCompare('tasks.dt_create', ">$today");
            }
            if ($model->chosenPeriod === 'week') {
                $weekAgo = date('Y-m-d H:i:s', strtotime('-1 weeks'));
                $request = $request->andFilterCompare('tasks.dt_create', ">$weekAgo");
            }
            if ($model->chosenPeriod === 'month') {
                $monthAgo = date('Y-m-d H:i:s', strtotime('1 months ago'));
                $request = $request->andFilterCompare('tasks.dt_create', ">$monthAgo");
            }
            if ($model->title) {
                $request = $request->andWhere('MATCH(title) AGAINST (:title)', [':title' => $model->title]);
            }
        }
        //кол-во элементов на странице
        $tasksLimit = 5;
        //кол-во всех записей
        $tasksNumber = $request->count();
        //количество страниц для пагинации
        $pages = ceil($tasksNumber / $tasksLimit);
        //оффсет
        $offset = ($curPage - 1) * $tasksLimit;

        $request = $request
            ->limit($tasksLimit)
            ->offset($offset);

        $tasks = $request->all();

        //передаю все в представление
        return $this->render('index', [
            'tasks' => $tasks,
            'categories' => $categories,
            'model' => $model,
            'pages' => $pages,
            'curPage' => $curPage
        ]);
    }
}
