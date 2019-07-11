<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "internal_pay".
 *
 * @property integer $id
 * @property integer $userID
 * @property string $website_name
 * @property string $website_url
 * @property string $customer_tell
 * @property string $website_desc
 * @property integer $website_categoryID
 * @property string $ip
 * @property integer $active
 * @property integer $deleted
 * @property integer $date
 * @property string $private_code
 * @property string $custom_code 
 *
 * @property User $user
 * @property WebsiteCategory $websiteCategory
 * @property ShaparakDetails[] $shaparakdetails 
 */
class InternalPay extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'internal_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'website_categoryID','custom_code', 'active', 'deleted', 'date'], 'integer'],
            [['website_name'], 'string', 'max' => 100],
            ['ip', 'ip'], // IPv4 or IPv6 address
            ['website_url', 'url'],
//                [['customer_tell', 'private_code'], 'string', 'max' => 255],
            ['customer_tell', 'number'],
            ['customer_tell', 'string', 'min' => 11],
            ['private_code', 'string', 'min' => 22],
            ['customer_tell', 'filter', 'filter' => 'trim'],
            ['customer_tell', 'unique'],
            [['website_desc'], 'string', 'max' => 455],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            [['website_categoryID'], 'exist', 'skipOnError' => true, 'targetClass' => WebsiteCategory::className(), 'targetAttribute' => ['website_categoryID' => 'id']],
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
            'website_name' => 'نام وب سایت',
            'website_url' => 'آدرس وب سایت',
            'customer_tell' => 'تلفن تماس',
            'website_desc' => 'توضیح وبسایت',
            'website_categoryID' => 'Website Category ID',
            'ip' => 'آی پی سایت شما',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'date' => 'Date',
            'private_code' => 'کد درگاه پرداخت(مرچنت کد)',
			'custom_code' => 'Custom Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
   	       return $this->hasOne(User::className(), ['id' => 'userID'])->inverseOf('internalpays');
		   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsiteCategory()
    {
           return $this->hasOne(WebsiteCategory::className(), ['id' => 'website_categoryID'])->inverseOf('internalpays');
		   }

    /**
     * @inheritdoc
     * @return InternalPayQuery the active query used by this AR class.
     */
    public static function find()
		{
     	    return new InternalPayQuery(get_called_class());
		 }

    public static function withUserId($userID, $active = null)
    {



        $query = new Query;
        $query->select('*')
                ->from('internal_pay')
//                ->join('inner join', 'bank_accounts', "bank_accounts.userID = contact.userID")
                ->where(['internal_pay.userID' => $userID]);

        if ($active == 1)
        {

            $query->andWhere(['internal_pay.active' => 1]);
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
	
	
	public static function getID ($custom)
	{
		   $query = new Query;
        $query->select('*')
                ->from('internal_pay')
//                ->join('inner join', 'bank_accounts', "bank_accounts.userID = contact.userID")
                ->where(['internal_pay.custom_code' => $custom]);
				  $command = $query->createCommand();
        $data = $command->queryOne();
				if(isset($data['id']))
				{
					
					return $data['id'];
					
				}
				else{
					return false;
				}
			

	}

}
