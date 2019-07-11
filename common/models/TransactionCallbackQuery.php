<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TransactionCallback]].
 *
 * @see TransactionCallback
 */
class TransactionCallbackQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TransactionCallback[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TransactionCallback|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
