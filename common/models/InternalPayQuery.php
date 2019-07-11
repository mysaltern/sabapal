<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[InternalPay]].
 *
 * @see InternalPay
 */
class InternalPayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return InternalPay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InternalPay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
