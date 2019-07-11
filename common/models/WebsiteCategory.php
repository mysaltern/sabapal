<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "website_category".
 *
 * @property integer $id
 * @property string $parent
 * @property string $name
 *
 * @property InternalPay[] $internalPays
 */
class WebsiteCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternalPays()
    {
        return $this->hasMany(InternalPay::className(), ['website_categoryID' => 'id']);
    }

    /**
     * @inheritdoc
     * @return WebsiteCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WebsiteCategoryQuery(get_called_class());
    }
}
