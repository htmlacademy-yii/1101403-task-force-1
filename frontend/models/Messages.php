<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $author_id
 * @property int $addressee_id
 * @property int $task_id
 * @property string $dt_create
 * @property string $text
 *
 * @property Alert[] $alerts
 * @property User $author
 * @property User $addressee
 * @property Task $task
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'addressee_id', 'task_id', 'text'], 'required'],
            [['author_id', 'addressee_id', 'task_id'], 'integer'],
            [['dt_create'], 'safe'],
            [['text'], 'string', 'max' => 16383],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['addressee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['addressee_id' => 'id']],
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
            'author_id' => 'Author ID',
            'addressee_id' => 'Addressee ID',
            'task_id' => 'Task ID',
            'dt_create' => 'Dt Create',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[Alerts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts()
    {
        return $this->hasMany(Alerts::className(), ['messages_id' => 'id']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Addressee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressee()
    {
        return $this->hasOne(Users::className(), ['id' => 'addressee_id']);
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
