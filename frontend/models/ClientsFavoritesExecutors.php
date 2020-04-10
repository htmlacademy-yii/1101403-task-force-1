<?php


namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "clients_favorites_executors".
 *
 * @property int $id
 * @property int $client_id
 * @property int $executive_id
 *
 * @property Users $executive
 * @property Users $client
 */
class ClientsFavoritesExecutors extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_favorites_executors';
    }

    public function rules ()
    {
        return [
            [['client_id', 'executive_id'], 'required'],
            [['client_id', 'executive_id'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['executive_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['executive_id' => 'id']]
        ];
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
     * Gets query for [[Executive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::className(), ['id' => 'client_id']);
    }
}
