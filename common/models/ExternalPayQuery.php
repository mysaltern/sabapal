<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ExternalPay]].
 *
 * @see ExternalPay
 */
class ExternalPayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ExternalPay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExternalPay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
