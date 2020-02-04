<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "alerts".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $reply_id
 * @property int $task_id
 * @property int|null $messages_id
 * @property string $note_type
 * @property int $is_new
 * @property string $dt_create
 *
 * @property TaskReply $reply
 * @property Task $task
 * @property Message $messages
 * @property User $user
 */
class Alerts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alerts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'note_type'], 'required'],
            [['user_id', 'reply_id', 'task_id', 'messages_id', 'is_new'], 'integer'],
            [['note_type'], 'string'],
            [['dt_create'], 'safe'],
            [['reply_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskReply::className(), 'targetAttribute' => ['reply_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['messages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['messages_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'reply_id' => 'Reply ID',
            'task_id' => 'Task ID',
            'messages_id' => 'Messages ID',
            'note_type' => 'Note Type',
            'is_new' => 'Is New',
            'dt_create' => 'Dt Create',
        ];
    }

    /**
     * Gets query for [[Reply]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReply()
    {
        return $this->hasOne(TaskReply::className(), ['id' => 'reply_id']);
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

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasOne(Message::className(), ['id' => 'messages_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
