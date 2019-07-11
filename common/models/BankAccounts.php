<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "bank_accounts".
 *
 * @property integer $id
 * @property integer $bankID
 * @property string $shaba
 * @property string $cartNumber
 * @property string $accountNumber
 * @property integer $status
 * @property integer $year
 * @property integer $userID
 * @property integer $primary
 * @property integer $month
 * @property integer $active
 * @property integer $time
 * @property integer $deleted
 *
 * @property User $user
 * @property BankList $bank
 */
class BankAccounts extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bankID', 'status', 'userID', 'primary', 'active', 'time', 'deleted'], 'integer'],
            [['shaba'], 'string', 'min' => 24, 'max' => 24],
            [['accountNumber'], 'string', 'max' => 16],
            [['cartNumber'], 'number', 'min' => 1000000000000000, 'max' => 9999999999999999, 'message' => 'شماره کارت صحیح نیست'],
            [['month'], 'integer', 'min' => 01, 'max' => 12],
            [['year'], 'integer', 'min' => 01, 'max' => 99],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            [['bankID'], 'exist', 'skipOnError' => true, 'targetClass' => BankList::className(), 'targetAttribute' => ['bankID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bankID' => 'Bank I D',
            'shaba' => 'شماره شبا',
            'cartNumber' => 'شماره کارت',
            'accountNumber' => 'شماره حساب',
            'status' => 'وضعیت',
            'year' => 'سال',
            'userID' => 'User I D',
            'primary' => 'کارت اصلی',
            'month' => 'ماه',
            'active' => 'فعال',
            'time' => 'زمان',
            'deleted' => 'Deleted',
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
    public function getBank()
    {
        return $this->hasOne(BankList::className(), ['id' => 'bankID']);
    }

    /**
     * @inheritdoc
     * @return BankAccountsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BankAccountsQuery(get_called_class());
    }

    public static function bank_list($userID, $primary)
    {




        $query = new Query;
        $query->select('*')
                ->from('bank_accounts')
//                ->join('inner join', 'bank_accounts', "bank_accounts.userID = contact.userID")
                ->where(['bank_accounts.userID' => $userID]);
        $query->andWhere(['bank_accounts.active' => 1]);
        if ($primary == 1)
        {
            $query->andWhere(['bank_accounts.primary' => 1]);
        }
        $command = $query->createCommand();
        $data = $command->queryOne();
        if (isset($data['id']))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

}
