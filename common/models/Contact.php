<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $name
 * @property string $lastName
 * @property string $nationalCode
 * @property string $address
 * @property string $mobile
 * @property string $tell
 * @property string $postalCode
 * @property integer $userID
 * @property integer $gender
 *
 * @property User $user
 */
class Contact extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'gender'], 'integer'],
            [['name', 'lastName', 'address'], 'string', 'max' => 255],
            [['mobile', 'nationalCode', 'tell'], 'string', 'max' => 25],
            [['postalCode'], 'string', 'max' => 10],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام',
            'lastName' => 'نام خانوادگی',
            'nationalCode' => 'کد ملی',
            'address' => 'آدرس',
            'mobile' => 'موبایل',
            'tell' => 'تلفن ثابت',
            'postalCode' => 'کد پستی',
            'userID' => 'آی دی کاربر',
            'gender' => 'جنسیت',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

}
