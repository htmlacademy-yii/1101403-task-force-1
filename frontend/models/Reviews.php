<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $client_id
 * @property int $executive_id
 * @property int $task_id
 * @property string|null $comment
 * @property string $rate
 * @property string $dt_create
 *
 * @property User $client
 * @property User $executive
 * @property Task $task
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'executive_id', 'task_id', 'rate'], 'required'],
            [['client_id', 'executive_id', 'task_id'], 'integer'],
            [['rate'], 'string'],
            [['dt_create'], 'safe'],
            [['comment'], 'string', 'max' => 16383],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['executive_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executive_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'task_id' => 'Task ID',
            'comment' => 'Comment',
            'rate' => 'Rate',
            'dt_create' => 'Dt Create',
        ];
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
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
