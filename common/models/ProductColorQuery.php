<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductColor]].
 *
 * @see ProductColor
 */
class ProductColorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductColor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductColor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
