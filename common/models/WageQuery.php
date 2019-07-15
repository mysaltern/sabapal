<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Wage]].
 *
 * @see Wage
 */
class WageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Wage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Wage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
