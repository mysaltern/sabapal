<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Profit]].
 *
 * @see Profit
 */
class ProfitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Profit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Profit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
