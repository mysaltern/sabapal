<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_list".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 *
 * @property BankAccounts[] $bankaccounts
 */
class BankList extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام بانک',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankaccounts()
    {
        return $this->hasMany(BankAccounts::className(), ['bankID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BankListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BankListQuery(get_called_class());
    }

}
