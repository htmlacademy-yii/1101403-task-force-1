<?php
namespace frontend\controllers;

use frontend\models\Users;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = Users::find()
            ->where(['role' => 'executive'])
            ->with(['executivesTasks', 'reviewsByExecutive'])
            ->groupBy('users.id')
            ->orderBy(['dt_reg' => SORT_DESC])->all();

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
        return $this->render('index', ['users' => $users]);
    }
}
