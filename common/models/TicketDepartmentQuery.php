<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TicketDepartment]].
 *
 * @see TicketDepartment
 */
class TicketDepartmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TicketDepartment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TicketDepartment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
