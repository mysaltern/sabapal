<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BankLog]].
 *
 * @see BankLog
 */
class BankLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BankLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BankLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
