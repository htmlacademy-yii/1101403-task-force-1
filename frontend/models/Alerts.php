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
 * @property int|null $message_id
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
            [['user_id', 'reply_id', 'task_id', 'message_id', 'is_new'], 'integer'],
            [['note_type'], 'string'],
            [['dt_create'], 'safe'],
            [['reply_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskReplies::className(), 'targetAttribute' => ['reply_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::className(), 'targetAttribute' => ['message_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'message_id' => 'Messages ID',
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
        return $this->hasOne(TaskReplies::className(), ['id' => 'reply_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Messages::className(), ['id' => 'message_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
