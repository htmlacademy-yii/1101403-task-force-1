<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\SearchUsersForm;
use frontend\models\Users;
use Yii;
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
            $model->validate();
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

        //рассчитываю рейтинг, количество заданий и отзывов для каждого юзера
        $this->addRating($users);

        return $this->render('index', ['users' => $users, 'categories' => $categories, 'model' => $model]);
    }

    /**
     * Метод рассчитывает и записывает в модели рейтинг юзеров
     * @param $users - массив с моделями юзеров, которым надо рассчитать рейтинг
     */
    protected function addRating(array $users) {
        foreach ($users as $user) {
            $user->setExTasksCount(count($user->executivesTasks));
            $user->setExReviewsCount(count($user->reviewsByExecutive));

            $rating = 0;
            $rateCount = 0;
            $sum = 0;
            foreach ($user->reviewsByExecutive as $review) {
                $sum += floatval($review->rate);
                $rateCount += 1;
            };
            if ($sum !== 0) {
                $rating = round($sum / $rateCount, 2);
            }

            $user->setRating($rating);
        }
    }

}
