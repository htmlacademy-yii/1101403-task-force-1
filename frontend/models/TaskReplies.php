<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_replies".
 *
 * @property int $id
 * @property int $executive_id
 * @property int $task_id
 * @property string|null $comment
 * @property int $price
 * @property string $dt_create
 *
 * @property Alert[] $alerts
 * @property User $executive
 * @property Task $task
 */
class TaskReplies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executive_id', 'task_id', 'price'], 'required'],
            [['executive_id', 'task_id', 'price'], 'integer'],
            [['dt_create'], 'safe'],
            [['comment'], 'string', 'max' => 16383],
            [['executive_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executive_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executive_id' => 'Executive ID',
            'task_id' => 'Task ID',
            'comment' => 'Comment',
            'price' => 'Price',
            'dt_create' => 'Dt Create',
        ];
    }

    /**
     * Gets query for [[Alerts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts()
    {
        return $this->hasMany(Alerts::className(), ['reply_id' => 'id']);
    }

    /**
     * Gets query for [[Executive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutive()
    {
        return $this->hasOne(Users::className(), ['id' => 'executive_id']);
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
}
