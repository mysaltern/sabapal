<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[WebsiteCategory]].
 *
 * @see WebsiteCategory
 */
class WebsiteCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WebsiteCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WebsiteCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
