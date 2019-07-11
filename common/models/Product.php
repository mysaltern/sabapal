<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property string $desc
 * @property integer $productCOLORID
 * @property integer $productCATEGORYID
 * @property integer $userID
 * @property integer $imageID
 * @property integer $time
 * @property integer $deleted
 * @property integer $active
 *
 * @property ProductColor $productcolor
 * @property ProductCategory $productcategory
 * @property ProductImage $image
 * @property User $user
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productCOLORID', 'productCATEGORYID', 'userID', 'imageID', 'time', 'deleted', 'active'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 800],
            [['productCOLORID'], 'exist', 'skipOnError' => true, 'targetClass' => ProductColor::className(), 'targetAttribute' => ['productCOLORID' => 'id']],
            [['productCATEGORYID'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['productCATEGORYID' => 'id']],
            [['imageID'], 'exist', 'skipOnError' => true, 'targetClass' => ProductImage::className(), 'targetAttribute' => ['imageID' => 'id']],
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
            'name' => 'Name',
            'name_en' => 'Name En',
            'desc' => 'Desc',
            'productCOLORID' => 'Product C O L O R I D',
            'productCATEGORYID' => 'Product C A T E G O R Y I D',
            'userID' => 'User I D',
            'imageID' => 'Image I D',
            'time' => 'Time',
            'deleted' => 'Deleted',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductcolor()
    {
        return $this->hasOne(ProductColor::className(), ['id' => 'productCOLORID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductcategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'productCATEGORYID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(ProductImage::className(), ['id' => 'imageID']);
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
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
