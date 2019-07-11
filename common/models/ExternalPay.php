<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "external_pay".
 *
 * @property integer $id
 * @property string $url
 * @property string $name
 *
 * @property BankLog[] $bankLogs
 */
class ExternalPay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'external_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankLogs()
    {
        return $this->hasMany(BankLog::className(), ['externalPayID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ExternalPayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExternalPayQuery(get_called_class());
    }
}
