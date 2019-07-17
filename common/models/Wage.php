<?php


namespace common\models;


use common\models\Wagedetail;
use Yii;
use yii\db\conditions\BetweenColumnsCondition;



/**
 * This is the model class for table "{{%wage}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property integer $erase
 *
 * @property Wagedetail[] $wagedetails
 */
class Wage extends \yii\db\ActiveRecord
    {


    /**
     * @inheritdoc
     */
    public static function tableName()
        {
        return '{{%wage}}';

        }


    /**
     * @inheritdoc
     */
    public function rules()
        {
        return [
                [['name', 'active'], 'required'],
                [['active', 'erase'], 'integer'],
                [['name'], 'string', 'max' => 255],
        ];

        }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
        {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'active' => Yii::t('app', 'Active'),
            'erase' => Yii::t('app', 'Erase'),
        ];

        }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWagedetails()
        {
        return $this->hasMany(Wagedetail::className(), ['wage_id' => 'id']);

        }


    /**
     * @inheritdoc
     * @return WageQuery the active query used by this AR class.
     */
    public static function find()
        {
        return new WageQuery(get_called_class());

        }


    public static function Wage($wagename, $date = false, $price)
    {


        $wage = Wage::find()->asArray()->where(['name' => $wagename])->one();
        // $wagedetail = Wagedetail::find()->asArray()->where(new BetweenColumnsCondition($price, 'BETWEEN', 'startprice', 'endprice'))->andWhere(['date' => $date, 'wage_id' => $wage['id']])->one();
        $wagedetails = Wagedetail::find()->where(new BetweenColumnsCondition($price, 'BETWEEN', 'startprice', 'endprice'));
        if (!$date)
        {

            $wagedetails->andWhere(['wage_id' => $wage['id']]);
        }else{
            $wagedetails ->andWhere(['date' => $date, 'wage_id' => $wage['id']]);
        }

        $wagedetail = $wagedetails->asArray()->one();

        $fixpercent = $wagedetail ['fixpercent'];
        $varpercent = $wagedetail ['varpercent'];

        if ($fixpercent) {
            $pricewhitefixpercent = $price - $fixpercent;
            return " Fix Wage : $fixpercent  ,<br>  Price White Fix Wage  :  $pricewhitefixpercent ";
        } elseif ($varpercent) {
            $pricewhitevarpercent = $price - ($price * ($varpercent / 100));
            return "Var Wage : %$varpercent ,<br> Price White Var Wage :  $pricewhitevarpercent";
        } else {
            return "No Wage ";
        }

    }



    }

