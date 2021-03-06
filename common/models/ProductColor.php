<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_color".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_en
 *
 * @property Product[] $products
 */
class ProductColor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'name_en'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['productCOLORID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductColorQuery(get_called_class());
    }
}
