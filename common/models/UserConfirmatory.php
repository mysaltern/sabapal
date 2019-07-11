<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_confirmatory".
 *
 * @property integer $id
 * @property string $nationalCard_url
 * @property string $birthCertificate_url
 * @property integer $userID
 * @property integer $active
 *
 * @property User $user
 */
class UserConfirmatory extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_confirmatory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['userID', 'active'], 'integer'],
                [['nationalCard_url', 'birthCertificate_url'], 'string', 'max' => 255],
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
            'nationalCard_url' => 'عکس کارت ملی',
            'birthCertificate_url' => 'عکس شناسنامه',
            'userID' => 'User ID',
            'active' => 'وضعیت',
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
     * @inheritdoc
     * @return UserConfirmatoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserConfirmatoryQuery(get_called_class());
    }

}
