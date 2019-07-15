<?php


namespace common\models;


use Yii;


/**
 * This is the model class for table "{{%wagedetail}}".
 *
 * @property integer $id
 * @property integer $wage_id
 * @property integer $fixpercent
 * @property integer $varpercent
 * @property string $date
 * @property integer $startprice
 * @property integer $endprice
 *
 * @property Wage $wage
 */
class Wagedetail extends \yii\db\ActiveRecord
    {


    /**
     * @inheritdoc
     */
    public static function tableName()
        {
        return '{{%wagedetail}}';

        }


    /**
     * @inheritdoc
     */
    public function rules()
        {
        return [
                [['wage_id', 'date', 'startprice', 'endprice'], 'required'],
                [['wage_id', 'fixpercent', 'varpercent', 'startprice', 'endprice'], 'integer'],
                [['date'], 'safe'],
                [['wage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wage::className(), 'targetAttribute' => ['wage_id' => 'id']],
        ];

        }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
        {
        return [
            'id' => Yii::t('app', 'ID'),
            'wage_id' => Yii::t('app', 'Wage ID'),
            'fixpercent' => Yii::t('app', 'Fixpercent'),
            'varpercent' => Yii::t('app', 'Varpercent'),
            'date' => Yii::t('app', 'Date'),
            'startprice' => Yii::t('app', 'Startprice'),
            'endprice' => Yii::t('app', 'Endprice'),
        ];

        }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWage()
        {
        return $this->hasOne(Wage::className(), ['id' => 'wage_id']);

        }


    /**
     * @inheritdoc
     * @return WagedetailQuery the active query used by this AR class.
     */
    public static function find()
        {
        return new WagedetailQuery(get_called_class());

        }


    }

