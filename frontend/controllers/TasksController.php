<?php
namespace frontend\controllers;


use frontend\models\Attachments;
use frontend\models\Categories;
use frontend\models\CreateTaskForm;
use frontend\models\SearchTaskForm;
use frontend\models\Users;
use Htmlacademy\logic\ExecutivesInfo;
use Yii;
use yii\data\Pagination;
use frontend\models\Tasks;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TasksController extends ControllerClass
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                $id = Yii::$app->user->id;
                $user = Users::findOne($id);

                return $user->role !== 'client';
            }
        ];
        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex()
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
        $model->load(Yii::$app->request->get());
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

        $count = $request->count();
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => 5,
            'route' => 'tasks/index'
        ]);
        $tasks = $request
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        //передаю все в представление
        return $this->render('index', [
            'tasks' => $tasks,
            'categories' => $categories,
            'model' => $model,
            'pagination' => $pagination
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $task = Tasks::find()
            ->where(['id' => $id])
            ->with(['category','city', 'client', 'taskReplies'])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }

        $executivesIds = [];
        foreach ($task->taskReplies as $reply) {
            $executivesIds[] = $reply->executive->id;
        }
        $info = new ExecutivesInfo($executivesIds);
        $ratings = $info->getRating();

        return $this->render('view', [
            'task' => $task,
            'ratings' => $ratings
        ]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new CreateTaskForm();
        $errors = [];
        $categoriesArray = Categories::find()->all();
        $categories = [];
        foreach ($categoriesArray as $category) {
            $categories[$category->id] = $category->title;
        }

        if (!Yii::$app->request->isPost) {
            return $this->render('create', [
                'categories' => $categories,
                'model' => $model,
                'errors' => $errors
            ]);
        }

        $model->load(Yii::$app->request->post());

        if (!$model->validate()) {
            $errors = $model->getErrors();
            return $this->render('create', [
                'categories' => $categories,
                'model' => $model,
                'errors' => $errors
            ]);
        }

        $task = new Tasks();
        $task->client_id = Yii::$app->user->getId();
        $task->cat_id = intval($model->chosenCategory);
        $task->status = 'new';
        $task->title = $model->title;
        $task->description = $model->description;
        $task->budget = intval($model->budget);
        $task->dt_end = $model->dt_end;
        $task->save();

        if (isset($model->attachments[0])) {
            $model->attachments = UploadedFile::getInstances($model, 'attachments');
            foreach ($model->attachments as $file) {
                $filePath = __DIR__ . '\..\web\uploads\\' . uniqid() . '.' . $file->extension;
                if ($file->saveAs($filePath)) {
                    $attachment = new Attachments();
                    $attachment->user_id = Yii::$app->user->getId();
                    $attachment->task_id = $task->id;
                    $attachment->attach_type = 'task';
                    $attachment->image_path = $filePath;
                    $attachment->save();
                }
            }
        }

        //TODO поменять роут на главную страницу
        return $this->redirect(['/tasks']);
    }

}
