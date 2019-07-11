<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[WageAmount]].
 *
 * @see WageAmount
 */
class WageAmountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WageAmount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WageAmount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
