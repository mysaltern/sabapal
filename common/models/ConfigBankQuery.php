<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ConfigBank]].
 *
 * @see ConfigBank
 */
class ConfigBankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ConfigBank[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ConfigBank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
