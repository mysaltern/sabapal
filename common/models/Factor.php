<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "factor".
 *
 * @property integer $id
 * @property string $name
 * @property string $lastname
 * @property integer $factorNumber
 * @property string $url
 * @property integer $dateFactor
 * @property string $mobile
 * @property string $email
 * @property integer $money
 * @property integer $status
 * @property integer $user_id
 *
 * @property User $user
 */
class Factor extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'factor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['name', 'lastname', 'factorNumber', 'dateFactor', 'mobile', 'money'], 'required'],
                [['factorNumber', 'dateFactor', 'user_id'], 'integer'],
                ['money', 'integer', 'min' => 1000, 'max' => 90000000],
                [['name'], 'string', 'max' => 25],
                [['lastname'], 'string', 'max' => 35],
                [['url'], 'string', 'max' => 20],
                [['mobile'], 'string', 'max' => 14, 'min' => 14],
//                [['mobile'], 'match', 'pattern' => '^(?:00|\+)[0-9]{4}-?[0-9]{7}$'],
            [['email'], 'string', 'max' => 40],
                ['email', 'email'],
                [['status'], 'string', 'max' => 1],
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
            'name' => 'نام',
            'lastname' => 'نام خانوادگی',
            'factorNumber' => 'شماره فاکتور',
            'url' => 'Url',
            'dateFactor' => 'تلریخ فاکتور',
            'mobile' => 'تلفن همراه',
            'email' => 'پست الکترونیکی',
            'money' => 'مبلغ',
            'status' => 'وضعیت',
            'user_id' => 'User ID',
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
     * @return FactorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FactorQuery(get_called_class());
    }

}
