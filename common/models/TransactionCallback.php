<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "transaction_callback".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property string $url
 *
 * @property Transaction $transaction
 */
class TransactionCallback extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_callback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['transaction_id', 'url'], 'required'],
                [['transaction_id'], 'integer'],
                [['url'], 'string', 'max' => 200],
                [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transaction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @inheritdoc
     * @return TransactionCallbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionCallbackQuery(get_called_class());
    }

    public static function urlWithToken($token, $orderID)
    {
 
        $query = new Query;
        $query->select('transaction_callback.url')
                ->from('transaction')
                ->join('inner join', 'transaction_callback', "transaction.id = transaction_callback.transaction_id")
                ->join('inner join', 'bank_log', "bank_log.orderID = transaction.id")
                ->where(['auth' => $token, 'transaction.id' => $orderID]);
        $command = $query->createCommand();
        $data = $command->queryOne();

        if (!empty($data['url']))
        {
            return $data['url'];
        }
        else
        {
            return false;
        }
    }
	
	  public static function urlWithOrder( $orderID)
    {
 
        $query = new Query;
        $query->select('transaction_callback.url')
                ->from('transaction_callback')
              //  ->join('inner join', 'transaction_callback', "transaction.id = transaction_callback.transaction_id") 
                ->where([ 'transaction_callback.transaction_id' => $orderID]);
        $command = $query->createCommand();
        $data = $command->queryOne();
 
        if (!empty($data['url']))
        {
            return $data['url'];
        }
        else
        {
            return false;
        }
    }

}
