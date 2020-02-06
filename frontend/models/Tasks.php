<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $client_id
 * @property int $executive_id
 * @property int $cat_id
 * @property int $city_id
 * @property string $status
 * @property string $title
 * @property string $description
 * @property int|null $budget
 * @property string $dt_create
 * @property string|null $dt_end
 * @property float|null $longitude
 * @property float|null $latitude
 * @property int|null $view_count
 *
 * @property Alert[] $alerts
 * @property Attachment[] $attachments
 * @property Message[] $messages
 * @property Review[] $reviews
 * @property TaskReply[] $taskReplies
 * @property User $client
 * @property User $executive
 * @property Category $cat
 * @property City $city
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'executive_id', 'cat_id', 'city_id', 'status', 'title', 'description'], 'required'],
            [['client_id', 'executive_id', 'cat_id', 'city_id', 'budget', 'view_count'], 'integer'],
            [['status'], 'string'],
            [['dt_create', 'dt_end'], 'safe'],
            [['longitude', 'latitude'], 'number'],
            [['title'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['executive_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executive_id' => 'id']],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
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
            'client_id' => 'Client ID',
            'executive_id' => 'Executive ID',
            'cat_id' => 'Cat ID',
            'city_id' => 'City ID',
            'status' => 'Status',
            'title' => 'Title',
            'description' => 'Description',
            'budget' => 'Budget',
            'dt_create' => 'Dt Create',
            'dt_end' => 'Dt End',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'view_count' => 'View Count',
        ];
    }

    /**
     * Gets query for [[Alerts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts()
    {
        return $this->hasMany(Alert::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskReplies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReplies()
    {
        return $this->hasMany(TaskReply::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Executive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutive()
    {
        return $this->hasOne(User::className(), ['id' => 'executive_id']);
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
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
}
