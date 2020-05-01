<?php
use Htmlacademy\logic\AgeCounter;
use Htmlacademy\logic\PluralForms;
use Htmlacademy\logic\TimeCounter;
use yii\helpers\Url;

?>
<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="/img/man-hat.png" width="120" height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?php echo $user->name ?: ''; ?></h1>
                <p>
                    Россия,
                    <?php
                    $counter = new AgeCounter($user->dt_birth);
                    $age = $counter->countAge() ?: '';
                    echo $user->city->title . ', ';
                    echo $age . ' ' . PluralForms::pluralNouns($age, 'год', 'года','лет');
                    ?>
                </p>
                <?php if ($user->role === 'executive'): ?>
                    <div class="profile-mini__name five-stars__rate">
                        <?php
                        $stars = intval(ceil($ratings[$user->id] ?: 0));
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
                        <b><?php echo $ratings[$user->id] ?: 0; ?></b>
                    </div>
                    <b class="done-task">
                        Выполнил
                        <?php
                        $ordersCount = count($user->executivesTasks);
                        echo $ordersCount . ' ' . PluralForms::pluralNouns($ordersCount, 'заказ', 'заказа', 'заказов');
                        ?>
                    </b>
                    <b class="done-review">
                        Получил
                        <?php
                        echo $reviewsCount . ' ' . PluralForms::pluralNouns($reviewsCount, 'отзыв', 'отзыва', 'отзывов');
                        ?>
                    </b>
                <?php endif; ?>
            </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <?php
                $counter = new TimeCounter($user->dt_last_visit);
                $timeString = $counter->countTimePassed();
                ?>
                <span>Был на сайте <?php echo $timeString; ?> назад</span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="content-view__description">
            <p><?php echo $user->bio ?: ''; ?></p>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <?php if ($user->role === 'executive'): ?>
                    <h3 class="content-view__h3">Специализации</h3>
                    <div class="link-specialization">
                        <?php foreach ($user->usersSpecialisations as $spec): ?>
                            <a href="#" class="link-regular"><?php echo $spec->title ?: ''; ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <?php if ($user->show_contacts): ?>
                        <a class="user__card-link--tel link-regular" href="#"><?php echo $user->phone ?: ''; ?></a>
                        <a class="user__card-link--email link-regular" href="#"><?php echo $user->email ?: ''; ?></a>
                        <a class="user__card-link--skype link-regular" href="#"><?php echo $user->skype ?: ''; ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($user->role === 'executive'): ?>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <a href="#"><img src="/img/rome-photo.jpg" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="/img/smartphone-photo.png" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="/img/dotonbori-photo.png" width="85" height="86" alt="Фото работы"></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($user->role === 'executive'): ?>
        <div class="content-view__feedback">
            <h2>Отзывы<span><?php echo '(' . $reviewsCount . ')'; ?></span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">
                <?php foreach ($user->reviewsByExecutive as $review): ?>
                    <?php if ($review->comment): ?>
                        <div class="feedback-card__reviews">
                            <p class="link-task link">Задание <a href="<?php echo Url::toRoute(['tasks/view', 'id' => $review->task_id]); ?>" class="link-regular">«<?php echo $review->task->title ?: ''; ?>»</a></p>
                            <div class="card__review">
                                <a href="#"><img src="/img/man-glasses.jpg" width="55" height="54"></a>
                                <div class="feedback-card__reviews-content">
                                    <p class="link-name link"><a href="#" class="link-regular"><?php echo $review->task->client->name ?: ''; ?></a></p>
                                    <p class="review-text">
                                        <?php echo $review->comment ?: ''; ?>
                                    </p>
                                </div>
                                <div class="card__review-rate">
                                    <?php
                                    $style = '';
                                    if (intval($review->rate) > 3) {
                                        $style = 'five-rate';
                                    } elseif (intval($review->rate) <= 3) {
                                        $style = 'three-rate';
                                    }
                                    ?>
                                    <p class="<?php echo $style; ?> big-rate"><?php echo $review->rate; ?><span></span></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<section class="connect-desk">
    <div class="connect-desk__chat">

    </div>
</section>
