<?php

use Htmlacademy\Logic\PluralForms;
use Htmlacademy\Logic\TimeCounter;
use yii\helpers\Url;
use Htmlacademy\Logic\Actions\AvailableActions;

/* @var $task frontend\models\Tasks */
/* @var $ratings array */

?>
<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?php echo $task->title ?: ''; ?></h1>
                    <span>Размещено в категории
                        <a href="#" class="link-regular"><?php echo $task->category->title ?: ''; ?></a>
                        <?php
                        $counter = new TimeCounter($task->dt_create);
                        echo $counter->countTimePassed() . ' назад';
                        ?></span>
                </div>
                <b class="new-task__price <?php echo ('new-task__price--' . $task->category->icon) ?: '';?> content-view-price"><?php echo $task->budget ?: ''; ?><b> ₽</b></b>
                <div class="new-task__icon <?php echo ('new-task__icon--' . $task->category->icon) ?: '';?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p><?php echo $task->description ?: ''; ?></p>
            </div>
            <?php if(!empty($task->attachments)): ?>
            <div class="content-view__attach">
                <h3 class="content-view__h3">Вложения</h3>
                <?php foreach($task->attachments as $attachment): ?>
                    <a href="<?php echo $attachment->image_path; ?>" download=""><?php echo $attachment->title; ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#"><img src="/img/map.jpg" width="361" height="292"
                                         alt="Москва, Новый арбат, 23 к. 1"></a>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town">Москва</span><br>
                        <span>Новый арбат, 23 к. 1</span>
                        <p>Вход под арку, код домофона 1122</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <?php ?>
            <button class="button button__big-color response-button open-modal"
                        type="button" data-for="response-form">Откликнуться</button>
            <button class="button button__big-color refusal-button open-modal"
                        type="button" data-for="refuse-form">Отказаться</button>
            <button class="button button__big-color request-button open-modal"
                  type="button" data-for="complete-form">Завершить</button>
        </div>
    </div>
        <?php
        $isAuthorOfReply = false;
        $isTaskAuthor = false;
        foreach($task->taskReplies as $reply) {
            if ($reply->executive_id === Yii::$app->user->getId()) {
                $isAuthorOfReply = true;
            }
        }
        if ($task->client_id === Yii::$app->user->getId()) {
            $isTaskAuthor = true;
        }
        ?>
        <?php if(count($task->taskReplies) > 0 && ($isTaskAuthor or $isAuthorOfReply)): ?>
            <div class="content-view__feedback">
                <h2>Отклики <span><?php echo '(' . count($task->taskReplies) . ')'; ?></span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($task->taskReplies as $reply): ?>
                        <?php if($isAuthorOfReply or $isTaskAuthor): ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="<?php echo Url::toRoute(['users/view', 'id' => $reply->executive_id]); ?>"><img src="/img/man-glasses.jpg" width="55" height="55"></a>
                                    <div class="feedback-card__top--name">
                                        <p><a href="<?php echo Url::toRoute(['users/view', 'id' => $reply->executive_id]); ?>" class="link-regular"><?php echo $reply->executive->name ?: ''; ?></a></p>
                                        <?php
                                        $stars = intval(ceil($ratings[$reply->executive->id] ?: 0));
                                        if ($stars > 0) {
                                            for ($i = 0; $i < $stars; $i++) {
                                                echo '<span></span>';
                                            }
                                        }
                                        $rest = 5 - $stars;
                                        if ($rest > 0) {
                                            for ($i = 0; $i < $rest; $i++) {
                                                echo '<span class="star-disabled"></span>';
                                            }
                                        }
                                        ?>
                                       <b><?php echo $ratings[$reply->executive->id] ?: 0; ?></b>
                                    </div>
                                    <span class="new-task__time">
                                        <?php
                                        $counter = new TimeCounter($reply->dt_create);
                                        echo $counter->countTimePassed() ?: '';
                                        ?></span>
                                </div>
                                <div class="feedback-card__content">
                                    <p><?php echo $reply->comment ?: ''; ?></p>
                                    <span><?php echo $reply->price ?: ''; ?> ₽</span>
                                </div>
                                <?php if($task->client_id === Yii::$app->user->getId() && $reply->status === 'new' && $task->status === 'new'): ?>
                                    <div class="feedback-card__actions">
                                        <a href="<?php echo Url::toRoute(['tasks/submit', 'executiveId' => $reply->executive_id, 'taskId' => $task->id]); ?>" class="button__small-color request-button button"
                                                type="button">Подтвердить</a>
                                        <a href="<?php echo Url::toRoute(['tasks/reject', 'replyId' => $reply->id, 'taskId' => $task->id]); ?>" class="button__small-color refusal-button button"
                                                type="button">Отказать</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="/img/man-brune.jpg" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?php echo $task->client->name ?: ''; ?></p>
                </div>
            </div>
            <p class="info-customer">
                <span>
                    <?php
                    $quantity = count($task->client->clientsTasks);
                    echo $quantity . ' ' . PluralForms::pluralNouns($quantity, 'задание', 'задания', 'заданий');
                    ?>
                </span>
                <span class="last-">
                    <?php $counter = new TimeCounter($task->client->dt_reg);
                    echo $counter->countTimePassed(); ?> на сайте
                </span></p>
            <a href="<?php echo Url::toRoute(['users/view', 'id' => $task->client->id]); ?>" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div class="connect-desk__chat">
        <h3>Переписка</h3>
        <div class="chat__overflow">
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:56</p>
                <p class="chat__message-text">Привет. Во сколько сможешь
                    приступить к работе?</p>
            </div>
            <div class="chat__message chat__message--in">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">На задание
                выделены всего сутки, так что через час</p>
            </div>
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
            </div>
        </div>
        <p class="chat__your-message">Ваше сообщение</p>
        <form class="chat__form">
            <textarea class="input textarea textarea-chat" rows="2" name="message-text" placeholder="Текст сообщения"></textarea>
            <button class="button chat__button" type="submit">Отправить</button>
        </form>
    </div>
</section>

