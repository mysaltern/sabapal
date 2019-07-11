<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_log".
 *
 * @property integer $id
 * @property integer $userID
 * @property string $auth
 * @property string $RetrivalRefNo
 * @property string $SystemTraceNo
 * @property integer $date
 * @property string $status
 * @property string $response
 * @property integer $externalPayID
 * @property integer $amount
 * @property integer $orderID
 *
 * @property User $user
 * @property ExternalPay $externalPay
 * @property Transaction $order
 * @property Transaction[] $transactions
 */
class BankLog extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['userID', 'date', 'externalPayID', 'amount', 'orderID'], 'integer'],
                [['auth', 'SystemTraceNo', 'RetrivalRefNo','response', 'status'], 'string', 'max' => 255],
                [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
                [['externalPayID'], 'exist', 'skipOnError' => true, 'targetClass' => ExternalPay::className(), 'targetAttribute' => ['externalPayID' => 'id']],
                [['orderID'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['orderID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'auth' => 'Auth',
            'date' => 'Date',
            'status' => 'Status',
            'response' => 'Response',
            'externalPayID' => 'External Pay ID',
            'amount' => 'Amount',
            'orderID' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalPay()
    {
        return $this->hasOne(ExternalPay::className(), ['id' => 'externalPayID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'orderID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['bankLogID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BankLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BankLogQuery(get_called_class());
    }

    public static function updateStatus($id)
    {


        Yii::$app->db->createCommand()
                ->update('bank_log', ['status' => 1], "orderID  =$id")
                ->execute();
    }

}
