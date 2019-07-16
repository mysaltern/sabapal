<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $sourceTypeID
 * @property string $sourceID
 * @property integer $date
 * @property integer $amount
 * @property integer $bankLogID
 * @property integer $status
 * @property integer $deleted
 * @property string $notes
 * @property string $token
 * @property string $cck
 *
 * @property User $user
 * @property Sourcetypes $sourceType
 * @property BankLog $bankLog
 */
class Transaction extends \yii\db\ActiveRecord
{

    const MIN_ADULT_FUNDS = 1000;
    const MAX_ADULT_FUNDS = 5000000;

    public $goal;
    public $mobile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goal', 'amount'], 'required'],
            [['userID', 'deleted', 'sourceTypeID', 'date', 'bankLogID', 'mobile', 'status'], 'integer'],
//                ['amount', 'integer', 'min' => 6, 'max' => 256],
            [['amount'], 'integer', 'max' => self::MAX_ADULT_FUNDS, 'min' => self::MIN_ADULT_FUNDS],
            [['notes', 'token', 'sourceID', 'cck'], 'string', 'max' => 255],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            [['sourceTypeID'], 'exist', 'skipOnError' => true, 'targetClass' => Sourcetypes::className(), 'targetAttribute' => ['sourceTypeID' => 'id']],
            [['bankLogID'], 'exist', 'skipOnError' => true, 'targetClass' => BankLog::className(), 'targetAttribute' => ['bankLogID' => 'id']],
            ['goal', 'string'],
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
            'sourceTypeID' => 'Source Type ID',
            'sourceID' => 'Source ID',
            'date' => 'تاریخ',
            'amount' => 'مبلغ (ریال)',
            'bankLogID' => 'Bank Log ID',
            'status' => 'وضعیت',
            'notes' => 'Notes',
            'cck' => 'Cck',
            'deleted' => 'deleted',
            'goal' => 'مقصد',
            'mobile' => 'شماره موبایل',
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
    public function getSourceType()
    {
        return $this->hasOne(Sourcetypes::className(), ['id' => 'sourceTypeID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankLog()
    {
        return $this->hasOne(BankLog::className(), ['id' => 'bankLogID']);
    }

    /**
     * @inheritdoc
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }

    public static function transfering($from, $to, $amount, $wallet = false)
    {
        $model = new Transaction;


        if ($wallet = true)
        {
            $fromSource = 8;
            $toSource = 9;
        }
        else
        {
            $fromSource = 2;
            $toSource = 3;
        }

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();
        try
        {

//            $cck = Yii::$app->Security->generate($from, $amount);
//            $fromM = $connection->createCommand()
//                    ->insert('transaction', [
//                        'userID' => $from,
//                        'sourceTypeID' => 2,
//                        'date' => time(),
//                        'cck' => 1,
//                        'amount' => $amount,
//                        'status' => 1,
//                        'deleted' => 0,
//                    ])
//                    ->execute();


            $transFrom = new Transaction;
            $transFrom->userID = $from;
            $transFrom->sourceID = $to;
            $transFrom->sourceTypeID = $fromSource;
            $transFrom->date = time();
            $transFrom->amount = $amount;
            $transFrom->status = 1;
            $transFrom->deleted = 0;
            $transFrom->save(false);
            $cck = Yii::$app->Security->generate($from, $amount, $transFrom->id);
            $transFrom->cck = $cck;

            $transFrom->save(false);



            $transTo = new Transaction;
            $transTo->userID = $to;
            $transTo->sourceID = $from;
            $transTo->sourceTypeID = $toSource;
            $transTo->date = time();
            $transTo->amount = $amount;
            $transTo->status = 1;
            $transTo->deleted = 0;
            $transTo->save(false);
            $cck = Yii::$app->Security->generate($to, $amount, $transTo->id);
            $transTo->cck = $cck;
            $transTo->save(false);



//
            $transaction->commit();

            return true;
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }

    public static function clearing($money, $userID)
    {
        $connection = \Yii::$app->db;

        $fromM = $connection->createCommand()
                ->insert('transaction', [
                    'userID' => $userID,
                    'sourceTypeID' => 4,
                    'date' => time(),
                    'amount' => $money,
                    'status' => 0,
                    'deleted' => 0,
                ])
                ->execute();
        $id = Yii::$app->db->getLastInsertID();
        $cck = Yii::$app->Security->generate(Yii::$app->user->id, $money, $id);
        Transaction::updateCCK($cck, $id);



        return true;
    }

    public static function updateCCK($cck, $id)
    {


        Yii::$app->db->createCommand()
                ->update('transaction', ['cck' => $cck], "id  =$id")
                ->execute();
    }

    public static function checkResult($id, $money)
    {
        $kol = Yii::$app->ReadHttpHeader->money($id);


        if ($kol - $money >= 0)
        {

            return true;
        }
        else
        {
            return false;
        }
    }

    public static function checkWithToken($token, $ip)
    {



        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,bank_log.id as checkStatus,internal_pay.website_url,internal_pay.ip')
                ->from('transaction')
                ->join('inner join', 'internal_pay', "transaction.userID = internal_pay.userID")
                ->join('inner join', 'bank_log', "bank_log.orderID = transaction.id")
                ->where(['active' => 1, 'transaction.deleted' => 0, 'transaction.token' => $token]);
        $command = $query->createCommand();
        $data = $command->queryOne();


        if (isset($data['ip']))
        {

            if ($data['ip'] == $ip)
            {

                return $data;
            }
            else
            {
                return false;
            }
        }
        else
        {

            return false;
        }
    }

    public static function checkWithTokenIPBlock($token)
    {



        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ')
                ->from('transaction')
//                ->join('inner join', 'internal_pay', "bank_log.orderID = transaction.id")
                ->where(['transaction.deleted' => 0, 'transaction.token' => $token]);
        $command = $query->createCommand();
        $data = $command->queryOne();


        if (isset($data['status']))
        {


            return $data;
        }
        else
        {


            return false;
        }
    }

    public static function checkWithTokenBank($token, $ip)
    {

//        $ipSave = Transaction::find()->innerJoin('transaction', "transaction.userID = internal_pay.userID")->all();
//        var_dump($ipSave);
//        die;


        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,internal_pay.website_url,internal_pay.ip,transaction.token')
                ->from('transaction')
                ->join('inner join', 'internal_pay', "transaction.userID = internal_pay.userID")
                ->join('inner join', 'bank_log', "bank_log.orderID = transaction.id")
                ->where(['active' => 1, 'transaction.deleted' => 0, 'bank_log.auth' => $token]);
        $command = $query->createCommand();
        $data = $command->queryOne();

        if (isset($data['ip']))
        {
            if ($data['ip'] == $ip)
            {
                return $data;
            }
            else
            {
                return false;
            }
        }
        else
        {

            return false;
        }
    }

    public static function checkWithTokenBankIPBlock($token)
    {

//        $ipSave = Transaction::find()->innerJoin('transaction', "transaction.userID = internal_pay.userID")->all();
//        var_dump($ipSave);
//        die;


        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,internal_pay.website_url,internal_pay.ip,transaction.token,transaction_callback.url as urlBack')
                ->from('transaction')
                ->join('inner join', 'internal_pay', "transaction.userID = internal_pay.userID")
                ->join('inner join', 'bank_log', "bank_log.orderID = transaction.id")
                ->join('inner join', 'transaction_callback', "transaction_callback.transaction_id = transaction.id")
                ->where(['internal_pay.active' => 1, 'transaction.deleted' => 0, 'bank_log.auth' => $token]);
        $command = $query->createCommand();
        $data = $command->queryOne();


        if (isset($data['ip']))
        {

            return $data;
        }
        else
        {

            return false;
        }
    }

    public static function checkPayment($id)
    {

        $query = new Query;
        $query->select('bank_log.status')
                ->from('bank_log')
                ->where(['orderID' => $id]);
        $command = $query->createCommand();
        $data = $command->queryOne();

        if ($data['status'] == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getUserIdWithToken($token)
    {

        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,transaction.userID')
                ->from('transaction')
//                ->join('inner join', 'internal_pay', "bank_log.orderID = transaction.id")
                ->where(['transaction.deleted' => 0, 'transaction.token' => $token]);
        $command = $query->createCommand();
        $data = $command->queryOne();


        if (isset($data['userID']))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

    public static function checkMethod()
    {

        if (isset($_GET['method']))
        {
            $method = $_GET['method'];

            if ($method == 'Online')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function getUrlWithToken($token)
    {
        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,internal_pay.website_url,internal_pay.ip,transaction.token')
                ->from('transaction')
                ->join('inner join', 'internal_pay', "transaction.userID = internal_pay.userID")
                ->join('inner join', 'bank_log', "bank_log.userID = transaction.userID")
                ->where(['active' => 1, 'transaction.deleted' => 0, 'bank_log.auth' => $token]);
        $command = $query->createCommand();
        $data = $command->queryOne();
    }

    public static function checkVerify($token, $money, $private, $ip)
    {
        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,internal_pay.website_url,internal_pay.ip,transaction.token')
                ->from('transaction')
                ->join('left join', 'internal_pay', "transaction.userID = internal_pay.userID")
                ->join('left join', 'bank_log', "bank_log.userID = transaction.userID")
                ->where(['active' => 1, 'transaction.deleted' => 0, 'transaction.token' => $token, 'private_code' => $private]);
        $command = $query->createCommand();
        $data = $command->queryOne();

        if (isset($data['amount']))
        {
            $moneyDatabse = $data['amount'];

            if ($moneyDatabse == $money * 10 and $data['status'] == 1)
            {

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function listRequest($userID)
    {
        $query = new Query;
        $query->select('transaction.status,transaction.amount,transaction.id ,transaction.sourceID')
                ->from('transaction')
//                ->join('inner join', 'internal_pay', "transaction.userID = internal_pay.userID")
//                ->join('inner join', 'bank_log', "bank_log.userID = transaction.userID")
                ->where(['transaction.deleted' => null, 'transaction.status' => -1, 'transaction.sourceTypeID' => 6, 'transaction.userID' => $userID]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        if (isset($data[0]))
        {
            return $data;
        }
    }

}
