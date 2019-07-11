<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $url
 * @property integer $active
 * @property integer $deleted
 *
 * @property Product[] $products
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'deleted'], 'integer'],
            [['name', 'desc', 'url'], 'string', 'max' => 255],
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
            'desc' => 'Desc',
            'url' => 'Url',
            'active' => 'Active',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['imageID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductImageQuery(get_called_class());
    }
}
