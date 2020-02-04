<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "clients_favorites_executors".
 *
 * @property int $id
 * @property int $client_id
 * @property int $executive_id
 *
 * @property User $client
 * @property User $executive
 */
class ClientsFavoritesExecutors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_favorites_executors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'executive_id'], 'required'],
            [['client_id', 'executive_id'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['executive_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executive_id' => 'id']],
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
}
