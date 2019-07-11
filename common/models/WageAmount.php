<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "wage_amount".
 *
 * @property integer $id
 * @property integer $fromAmount
 * @property integer $toAmount
 * @property integer $staticAmount
 * @property integer $percent
 * @property integer $active
 */
class WageAmount extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wage_amount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fromAmount', 'toAmount', 'staticAmount', 'percent', 'active'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fromAmount' => 'From Amount',
            'toAmount' => 'To Amount',
            'staticAmount' => 'Static Amount',
            'percent' => 'Percent',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return WageAmountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WageAmountQuery(get_called_class());
    }

    public static function amountCheck($userID, $amount)
    {
        $query = new Query;
        $query->select('*')
                ->from('wage_amount')
                ->where(['and', "toAmount>=$amount", "fromAmount<=$amount"])
                ->andwhere(['wage_amount.active' => 1]);
        $command = $query->createCommand();
        $data = $command->queryOne();
        if (isset($data['id']))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

}
