<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "short_link".
 *
 * @property integer $id
 * @property string $link
 * @property string $shortLink
 */
class ShortLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'short_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'string', 'max' => 255],
            [['shortLink'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'shortLink' => 'Short Link',
        ];
    }

    /**
     * @inheritdoc
     * @return ShortLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShortLinkQuery(get_called_class());
    }
}
