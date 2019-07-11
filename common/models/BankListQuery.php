<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BankList]].
 *
 * @see BankList
 */
class BankListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BankList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BankList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
