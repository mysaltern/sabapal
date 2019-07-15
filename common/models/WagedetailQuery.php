<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Wagedetail]].
 *
 * @see Wagedetail
 */
class WagedetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Wagedetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Wagedetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
