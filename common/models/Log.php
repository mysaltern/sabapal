<?php

namespace common\models;

use Yii;

use yii\httpclient\Client;
/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $time
 * @property integer $logTYPE
 * @property integer $active
 * @property integer $admin_active
 * @property integer $deleted
 * @property integer $active_time
 * @property integer $sourceID
 * @property string $table_name
 *
 * @property User $user
 * @property LogType $logtype
 */
class Log extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'time', 'logTYPE', 'active', 'admin_active', 'deleted', 'active_time', 'sourceID'], 'integer'],
            [['sourceID', 'table_name'], 'required'],
            [['table_name'], 'string', 'max' => 50],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            [['logTYPE'], 'exist', 'skipOnError' => true, 'targetClass' => LogType::className(), 'targetAttribute' => ['logTYPE' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User I D',
            'time' => 'Time',
            'logTYPE' => 'Log T Y P E',
            'active' => 'Active',
            'admin_active' => 'Admin Active',
            'deleted' => 'Deleted',
            'active_time' => 'Active Time',
            'sourceID' => 'sourceID',
            'table_name' => 'Table Name',
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
    public function getLogtype()
    {
        return $this->hasOne(LogType::className(), ['id' => 'logTYPE']);
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }

    public static function create($userID, $table, $sourceID, $type, $webservice = false)
    {
        $connection = Yii::$app->db;

        $connection->createCommand()->insert("log", [
                    'userID' => "$userID",
                    'time' => time(),
                    'logTYPE' => $type,
                    'active' => 1,
                    'admin_active' => 0,
                    'sourceID' => $sourceID,
                    'table_name' => $table,
                    'deleted' => 0,
                    'active_time' => 0,
                ])
                ->execute();

        $id = Yii::$app->db->getLastInsertID();


        if ($webservice == true)
        {
            //
            // ثبت ترمینال جدید   = 5
            //ثبت درخواست تغییر شباهای متصل = 6
			// 7 غیر فعال سازی پایانه
            //ثبت درخواست تعریف مشتری و فروشگاه = 13
		    //14 اصلاح اطلاعات فروشگاه
            //درخواست تغییر آدرس فروشگاه پذیرنده = 17
            //درخواست فعال سازی ترمینال =18

            $sec = Yii::$app->Data->security();
  	        $secEND = Yii::$app->Data->securityEND();
			
            $merchent = Yii::$app->Data->merchent($userID,$type);
            $shops = Yii::$app->Data->shops($userID,$type);
         
		     $acceptors = Yii::$app->Data->acceptors($userID,$type);
	 
		 
            $contract = $id;
			$contract  = array('contractDate'=>"2019-04-23",'expiryDate'=>"2020-12-08",'serviceStartDate'=>"2019-04-23",'contractNumber'=>$contract,'description'=>"",'updateAction'=>0);
             //
     
		 $shopArr = array();
		 $shopArr['shop']= $shops;
		 
				if($type ==13)
				{
					$shopArr['acceptors']=null;
				}
				else
				{
					$shopArr['acceptors'][] =  $acceptors;
				}
	
	//  var_dump($shopArr);
	//  die;
			$test = array("trackingNumberPsp"=>"11111111",'requestType'=>$type,'merchant'=>$merchent
		,'relatedMerchants'=>null,'contract'=>$contract,'pspRequestShopAcceptors'=>[$shopArr],'description'=>null); 
//$test = json_encode($test);
 
 
  
  
 // baraye moshahede json ghabl az ersal be shaparak hatman var_dump va die bashad

 var_dump($test);
die;
 
 
		$urlSmall=	Yii::$app->params['baseURlEND'];
		$urlLarge=	Yii::$app->params['saveURL'];
 //echo $urlSmall.$urlLarge;
		$client = new Client();
		$response = $client->createRequest()
		->setFormat(Client::FORMAT_JSON)
	    ->setMethod('POST')
		->setUrl("$urlSmall/$urlLarge")
		->addHeaders(['Authorization' => "Basic $secEND"])
	    ->setData([$test])
 
	 //   ->setData(		[$test ] 	 	 )
		->send();
 
var_dump($response->content);
die;
		
        //
        //
        }
        return $id;
    }

}
