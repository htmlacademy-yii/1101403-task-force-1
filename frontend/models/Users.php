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
 * @property Alert[] $alerts
 * @property Attachment[] $attachments
 * @property ClientsFavoritesExecutor[] $clientsFavoritesExecutors
 * @property ClientsFavoritesExecutor[] $clientsFavoritesExecutors0
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property TaskReply[] $taskReplies
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property City $city
 * @property UsersSpecialisation[] $usersSpecialisations
 */
class Users extends \yii\db\ActiveRecord
{
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
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
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

    /**
     * Gets query for [[Alerts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts()
    {
        return $this->hasMany(Alert::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ClientsFavoritesExecutors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientsFavoritesExecutors()
    {
        return $this->hasMany(ClientsFavoritesExecutor::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[ClientsFavoritesExecutors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientsFavoritesExecutors0()
    {
        return $this->hasMany(ClientsFavoritesExecutor::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['addressee_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Review::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[TaskReplies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReplies()
    {
        return $this->hasMany(TaskReply::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['executive_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UsersSpecialisations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSpecialisations()
    {
        return $this->hasMany(UsersSpecialisation::className(), ['user_id' => 'id']);
    }
}
