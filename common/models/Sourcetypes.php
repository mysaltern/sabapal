<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sourcetypes".
 *
 * @property integer $id
 * @property string $name
 * @property integer $opration
 *
 * @property Transaction[] $transactions
 */
class Sourcetypes extends \yii\db\ActiveRecord
    {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sourcetypes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['opration'], 'integer'],
                [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'تراکنش بابت',
            'opration' => 'Opration',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['sourceTypeID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SourcetypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SourcetypesQuery(get_called_class());
    }

    }
