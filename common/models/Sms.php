<?php

namespace common\models;

use Yii;
use hoomanMirghasemi\jdf\Jdf;
use SoapClient;

/**
 * This is the model class for table "sms".
 *
 * @property integer $id
 * @property string $titr
 * @property string $dec
 * @property string $option
 * @property string $latestPurchase
 * @property string $countPurchase
 * @property string $time
 * @property integer $user_id
 *
 * @property ConSms[] $conSms
 * @property User $user
 */
class Sms extends \yii\db\ActiveRecord
{

    public $subcat;
    public $sex;
    public $cat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['user_id'], 'integer'],
                [['titr'], 'string', 'max' => 50],
                [['dec'], 'string', 'max' => 1000],
                [['dec', 'titr', 'option'], 'required', 'isEmpty' => function ($value)
                {
                    return empty($value);
                }],
                [['option'], 'string', 'max' => 20],
                [['latestPurchase', 'countPurchase'], 'string', 'max' => 255],
                [['time'], 'string', 'max' => 5],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'کد',
            'titr' => 'عنوان',
            'dec' => 'متن',
            'option' => 'زمان ارسال',
            'latestPurchase' => ' آخرین خرید',
            'countPurchase' => 'جمع خرید ها',
            'time' => 'ساعت ارسال',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConSms()
    {
        return $this->hasMany(ConSms::className(), ['sms_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return SmsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SmsQuery(get_called_class());
    }

    public function send($name, $lastName, $mobile, $time, $job, $sex, $text, $saat)
    {

        ini_set('max_execution_time', 300);
        ini_set('default_socket_timeout', 300);
        $model = new Sms();
        $saltern = new \app\models\saltern();


        $send = TRUE;


        $text = $saltern->actionText($sex, $name, $lastName, $text, $job);
        $time = explode("/", $time);
        $sal = $time[0];
        $mah = $time[1];
        $rooz = $time[2];
        $khareji = Jdf::jalali_to_gregorian($sal, $mah, $rooz);
        if (isset($saat))
        {
            $saat = $saat;
        }
        else
        {
            $saat = "11:00";
        }

        $saat = "11:00";
// تولید سال برای ارسال تولد و یا تاریخ مهم
//
//
//
//
//



        $y = date("Y");
        $tavalod = strtotime("$khareji[2].$khareji[1].$y");
        $natification = $tavalod - time();
        if ($natification < 0)
        {
            $y = date("Y") + 1;
            $khareji[2] = ($khareji[2] - 1 );
            if ($khareji[2] == 0)
            {
                $khareji = Jdf::jalali_to_gregorian($sal, $mah, $rooz - 1);
            }
            if ($khareji[2] < 10)
            {
                $khareji[2] = '0' . $khareji[2];
            }
        }
        else
        {
            $y = date("Y");
            if ($khareji[2] < 10)
            {
                $khareji[2] = '0' . ($khareji[2]);
            }
        }
        if ($khareji[1] < 10)
        {
            $khareji[1] = '0' . $khareji[1];
        }
//
//
//
//
//
//
//
// تولید سال برای ارسال تولد و یا تاریخ مهم








        if ($model)
            ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient('http://api.payamak-panel.com/post/schedule.asmx?wsdl', array('encoding' => 'UTF-8'));
        $parameters['username'] = $saltern->username;
        $parameters['password'] = $saltern->password;
        $parameters['from'] = $saltern->from;
        $parameters['to'] = $mobile;
        $parameters['text'] = $text;
        $parameters['isflash'] = false;


        $parameters['scheduleDateTime'] = "$y-$khareji[1]-$khareji[2]T$saat:59";
        $parameters['period'] = "Once";
        if ($send == TRUE)
        {
            echo $sms_client->AddSchedule($parameters)->AddScheduleResult;
        }
    }

    public function remove($scheduleId)
    {
        ini_set('max_execution_time', 300);
        ini_set('default_socket_timeout', 300);
        $model = new Sms();
        $saltern = new \app\models\saltern();

        if ($model)
            ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient('http://api.payamak-panel.com/post/schedule.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = $saltern->username;
        $parameters['password'] = $saltern->password;
        $parameters['scheduleId'] = $scheduleId;
        $sms_client->RemoveSchedule($parameters);
    }

    public function getStatus($smsId, $return)
    {
        ini_set('max_execution_time', 300);
        ini_set('default_socket_timeout', 300);
        $model = new Sms();
        $saltern = new \app\models\saltern();


        if ($model)
            ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient('http://api.payamak-panel.com/post/schedule.asmx?wsdl', array('encoding' => 'UTF-8'));


        $parameters['username'] = $saltern->username;
        $parameters['password'] = $saltern->password;
        $parameters['scheduleId'] = $smsId;
        $status = $sms_client->GetScheduleStatus($parameters)->GetScheduleStatusResult;
        if ($return == 1)
        {
            $status2 = 'خطا! با پشتیباننی تماس بگیرید';


            if ($status == '0')
            {
                $status2 = "منتظر ارسال";
            }
            elseif ($status == '2')
            {
                $status2 = "ارسال شده";
            }
            elseif ($status == '3')
            {
                $status2 = "ارسال نشده";
            }
            elseif ($status == '4')
            {
                $status2 = "کنسل شده";
            }
            elseif ($status == '5')
            {
                $status2 = "حذف شده";
            }
            elseif ($status == '6')
            {
                $status2 = "تایید نشده";
            }
            elseif ($status == '10')
            {
                $status2 = "منتظر تایید";
            }
            elseif ($status == '-1')
            {
                $status2 = "حذف شده";
            }



            return $status2;
        }
        else
        {
            return $status;
        }
    }

}
