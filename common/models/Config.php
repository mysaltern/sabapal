<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $percent
 * @property string $config
 * @property integer $configBANKID
 *
 * @property ConfigBank $configbank
 */
class Config extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['configBANKID'], 'integer'],
            [['percent', 'config'], 'string', 'max' => 255],
            [['configBANKID'], 'exist', 'skipOnError' => true, 'targetClass' => ConfigBank::className(), 'targetAttribute' => ['configBANKID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'percent' => 'Percent',
            'config' => 'Config',
            'configBANKID' => 'Config B A N K I D',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigbank()
    {
        return $this->hasOne(ConfigBank::className(), ['id' => 'configBANKID']);
    }

    /**
     * @inheritdoc
     * @return ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigQuery(get_called_class());
    }

    public static function checkOurShaba($name)
    {

        $query = new Query;
        $query->select('*')
                ->from('config')
                ->join('inner join', 'config_bank', "config_bank.id = config.configBANKID")
//                ->join('inner join', 'bank_log', "bank_log.orderID = transaction.id")
                ->where(['config_bank.active' => 1, 'config_bank.name' => $name]);
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
