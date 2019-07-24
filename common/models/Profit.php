<?php


namespace common\models;


use hoomanMirghasemi\jdf\Jdf;
use Yii;


/**
 * This is the model class for table "{{%profit}}".
 *
 * @property int $id
 * @property int $percent
 * @property int $method
 */
class Profit extends \yii\db\ActiveRecord
    {


    /**
     * {@inheritdoc}
     */
    public static function tableName()
        {
        return '{{%profit}}';

        }


    /**
     * {@inheritdoc}
     */
    public function rules()
        {
        return [
                [['percent', 'method'], 'required'],
                [['percent', 'method'], 'integer'],
        ];

        }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
        {
        return [
            'id' => Yii::t('app', 'ID'),
            'percent' => Yii::t('app', 'Percent'),
            'method' => Yii::t('app', 'Method'),
        ];

        }


    /**
     * {@inheritdoc}
     * @return ProfitQuery the active query used by this AR class.
     */
    public static function find()
        {
        return new ProfitQuery(get_called_class());

        }


    public static function getProfit()
        {
        $profit = Profit::find()->one();
        return $profit;

        }


    public static function Profit($user_id, $percent)
        {
        //  function for calculate profit for 30 days
        //  $money = Yii::$app->ReadHttpHeader->money(Yii::$app->user->id);
        //   $userID = Yii::$app->user->id;
        //   $userData = \dektrium\user\models\User::find()->asArray()->where(['id' => $userID])->one();
        //   $openingData = $userData['created_at'];
        //   $date_display = date('Y-m-d H:i:s', $openingData);
        //   $current = date('Y-m-d H:i:s');
        //   $datetime1 = date_create($date_display);
        //   $datetime2 = date_create($current);
        //    $interval = date_diff($datetime1, $datetime2);
        //  $days = $interval->d;
//        if (is_int($days / 30)) {
//            $profit = $money + (($money * 0.1) / 12);
//            return "account balance : $profit";
//        }
//        return 0;
//        $money = Yii::$app->ReadHttpHeader->money($user_id); // kamtarin mande hesab dar mah
//        // $userID = Yii::$app->user->id;
//        $userData = \dektrium\user\models\User::find()->asArray()->where(['id' => $user_id])->one();
//        $openingData = $userData['created_at'];
//        $date_display = Jdf::jdate('Y-m-d H:i:s', $openingData, '', '', 'en');
//        $currentData = Jdf::jdate('Y-m-01 H:i:s', '', '', '', 'en');
//        $datetime1 = date_create($date_display);
//        $datetime2 = date_create($currentData);
//        $interval = date_diff($datetime1, $datetime2);
//        $days = $interval->d;
//        $month = $interval->m;
//        $year = $interval->y;
//
//        if ($days > 25 or $month >= 1 or $year >= 1)
//            {
//            $profit = (($money * ($percent / 100)) / 12);
//            return "account balance : $profit";
//            }
//        return 0;

        }


    }

