<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $verify
 * @property integer $req_source
 *
 * @property Log[] $logs
 */
class LogType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verify', 'req_source'], 'integer'],
            [['name'], 'string', 'max' => 60],
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
            'verify' => 'Verify',
            'req_source' => 'Req Source',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['logTYPE' => 'id']);
    }

    /**
     * @inheritdoc
     * @return LogTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogTypeQuery(get_called_class());
    }
}
