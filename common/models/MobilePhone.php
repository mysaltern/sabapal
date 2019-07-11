<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mobile_phone".
 *
 * @property integer $id
 * @property integer $token
 * @property integer $user_id
 * @property string $mobile
 * @property integer $time
 * @property integer $count
 * @property integer $status
 * @property integer $active
 *
 * @property User $user
 */
class MobilePhone extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['token', 'user_id', 'time', 'count', 'status', 'active'], 'integer'],
                [['mobile'], 'string', 'max' => 11],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'رمز یکبار مصرف',
            'user_id' => 'User ID',
            'mobile' => 'تلفن همراه',
            'time' => 'Time',
            'count' => 'Count',
            'status' => 'Status',
            'active' => 'Active',
        ];
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
     * @return MobilePhoneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MobilePhoneQuery(get_called_class());
    }

    public static function getMobile($userID)
    {

        $mobile = \common\models\MobilePhone::find()->select('mobile')->where(['user_id' => $userID, 'active' => 1, 'status' => 1])->asArray()->one();
        if (isset($mobile['mobile']))
        {
            return $mobile['mobile'];
        }
        else
        {
            return false;
        }
    }

}
