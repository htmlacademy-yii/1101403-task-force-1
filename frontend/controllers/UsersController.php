<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\SearchUsersForm;
use frontend\models\Users;
use Htmlacademy\logic\ExecutivesInfo;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;


class UsersController extends ControllerClass
{
    public function actionIndex($sort = 'dt_reg')
    {
        $listStyle = [];
        $request = Users::find()
            ->where(['users.role' => 'executive'])
            ->with(['executivesTasks', 'reviewsByExecutive', 'usersSpecialisations'])
            ->groupBy('users.id');
        if ($sort === 'order_count') {
            $listStyle['order_count'] = 'user__search-item--current';
            $request = $request
                ->select('users.*, COUNT(tasks.id) AS order_count')
                ->joinWith('executivesTasks');
        } elseif ($sort === 'rating') {
            $listStyle['rating'] = 'user__search-item--current';
            $request = $request
                ->select('users.*, AVG(reviews.rate) AS rating')
                ->joinWith('reviewsByExecutive');
        } elseif ($sort === 'view_count') {
            $listStyle['view_count'] = 'user__search-item--current';
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
        $model->load(Yii::$app->request->get());
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
            //TO DO: брать u.id из сессии
            $request = $request
                ->joinWith('executorsInFavor u')
                ->andWhere(['u.id' => 11]);
        }
        if ($model->name) {
            $request = $request->andWhere('MATCH(name) AGAINST (:name)', [':name' => $model->name]);
        }

        $count = $request->count();
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => 5,
            'route' => 'users/index'
        ]);
        $users = $request
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        // получаю массив id пользователей
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }

        //рассчитываю рейтинг, количество заданий и отзывов для каждого юзера
        $info = new ExecutivesInfo($userIds);
        $ratings = $info->getRating();
        $tasksCount = $info->getTasks();
        $reviewsCount = $info->getReviews();

        //передаю все в представление
        return $this->render('index', [
            'users' => $users,
            'categories' => $categories,
            'model' => $model,
            'ratings' => $ratings,
            'tasksCount' => $tasksCount,
            'reviewsCount' => $reviewsCount,
            'listStyle' => $listStyle,
            'sort' => $sort,
            'pagination' => $pagination
        ]);
    }

    /**
     * @param int $id  юзера, запись которого нужно показать
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = Users::find()
            ->where(['id' => $id])
            ->with(['usersSpecialisations', 'reviewsByExecutive', 'city', 'executivesTasks'])
            ->one();

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с ID $id не найден");
        }

        $info = new ExecutivesInfo([$id]);
        $ratings = $info->getRating();
        $reviewsCount = $info->getReviews();
        $reviewsCount = $reviewsCount[$user->id];

        return $this->render('view', [
            'user' => $user,
            'ratings' => $ratings,
            'reviewsCount' => $reviewsCount
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['landing/']);
    }

}
