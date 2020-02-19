<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $city_id
 * @property string $role
 * @property int $message_alert
 * @property int $action_alert
 * @property int $review_alert
 * @property int $show_contacts
 * @property int $show_profile
 * @property string $name
 * @property string|null $avatar_path
 * @property string $dt_reg
 * @property string|null $dt_birth
 * @property string $dt_last_visit
 * @property string $email
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $oth_contact
 * @property string $password
 * @property float|null $longitude
 * @property float|null $latitude
 * @property string|null $bio
 *
 * @property Alerts[] $alerts
 * @property Attachments[] $attachments
 * @property Users[] $clientsFavoritesExecutors
 * @property Messages[] $messagesByAuthor
 * @property Messages[] $messagesByAddressee
 * @property Reviews[] $reviewsByClient
 * @property Reviews[] $reviewsByExecutive
 * @property TaskReplies[] $taskReplies
 * @property Tasks[] $clientsTasks
 * @property Tasks[] $executivesTasks
 * @property Cities $city
 * @property Categories[] $usersSpecialisations
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @var - рейтинг исполнителя
     */
    private $_rating;

    private $_exTasksNumber;

    private $_exReviewsNumber;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'role', 'name', 'email', 'password'], 'required'],
            [['city_id', 'message_alert', 'action_alert', 'review_alert', 'show_contacts', 'show_profile'], 'integer'],
            [['role'], 'string'],
            [['dt_reg', 'dt_birth', 'dt_last_visit'], 'safe'],
            [['longitude', 'latitude'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['avatar_path', 'password'], 'string', 'max' => 128],
            [['email', 'skype', 'oth_contact'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 32],
            [['bio'], 'string', 'max' => 16383],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'role' => 'Role',
            'message_alert' => 'Message Alert',
            'action_alert' => 'Action Alert',
            'review_alert' => 'Review Alert',
            'show_contacts' => 'Show Contacts',
            'show_profile' => 'Show Profile',
            'name' => 'Name',
            'avatar_path' => 'Avatar Path',
            'dt_reg' => 'Dt Reg',
            'dt_birth' => 'Dt Birth',
            'dt_last_visit' => 'Dt Last Visit',
            'email' => 'Email',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'oth_contact' => 'Oth Contact',
            'password' => 'Password',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'bio' => 'Bio',
        ];
    }

    public function setRating($rating)
    {
        $this->_rating = round((float)$rating, 2);
    }

    public function getRating()
    {
        if ($this->isNewRecord) {
            return null;
        }

        if ($this->_rating === null && $this->role === 'executive') {
            $this->setRating(Reviews::find()->select('AVG(rate)')->where(['id' => $this->id]));
            return $this->_rating;
        }
        echo $this->_rating;
    }

    public function setExTasksNumber($tasksNumber)
    {
        $this->_exTasksNumber = (int)$tasksNumber;
    }

    public function getExTasksNumber()
    {
        if ($this->isNewRecord) {
            return null;
        }

        if ($this->_exTasksNumber === null) {
            $this->setExTasksNumber($this->getExecutivesTasks()->count());
        }

        return $this->_exTasksNumber;
    }

    public function setExReviewsNumber($reviewsNumber)
    {
        $this->_exReviewsNumber = (int)$reviewsNumber;
    }

    public function getExReviewsNumber()
    {
        if ($this->isNewRecord) {
            return null;
        }

        if ($this->_exReviewsNumber === null) {
            $this->setExReviewsNumber($this->getReviewsByExecutive()->count());
        }

        return $this->_exReviewsNumber;
    }



    /**
     * Gets query for [[Alerts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts()
    {
        return $this->hasMany(Alerts::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ClientsFavoritesExecutors]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getClientsFavoritesExecutors()
    {
        return $this->hasMany(Users::className(), ['id' => 'executive_id'])->viaTable('clients_favorites_executors',['client_id' => 'id']);
    }

    /**
     * Gets query for [[UsersSpecialisations]].
     */
    public function getUsersSpecialisations()
    {
        return $this->hasMany(Categories::className(), ['id' => 'cat_id'])->viaTable('users_specialisations',['user_id' => 'id']);
    }


    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessagesByAuthor()
    {
        return $this->hasMany(Messages::className(), ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessagesByAddressee()
    {
        return $this->hasMany(Messages::className(), ['addressee_id' => 'id']);
    }

    /**
     * Gets query for [[ReviewsByClient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewsByClient()
    {
        return $this->hasMany(Reviews::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[ReviewsbyExecutive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewsByExecutive()
    {
        return $this->hasMany(Reviews::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[TaskReplies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReplies()
    {
        return $this->hasMany(TaskReplies::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientsTasks()
    {
        return $this->hasMany(Tasks::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutivesTasks()
    {
        return $this->hasMany(Tasks::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

}
