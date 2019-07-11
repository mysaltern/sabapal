<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config_bank".
 *
 * @property integer $id
 * @property string $name
 * @property string $shaba
 * @property string $cardNumber
 * @property string $accountNumber
 * @property integer $active
 *
 * @property Config[] $configs
 */
class ConfigBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['name', 'shaba'], 'string', 'max' => 255],
            [['cardNumber'], 'string', 'max' => 12],
            [['accountNumber'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'shaba' => 'Shaba',
            'cardNumber' => 'Card Number',
            'accountNumber' => 'Account Number',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigs()
    {
        return $this->hasMany(Config::className(), ['configBANKID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ConfigBankQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigBankQuery(get_called_class());
    }
}
