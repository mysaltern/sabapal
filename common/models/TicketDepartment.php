<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ticket_department".
 *
 * @property integer $id
 * @property string $name
 */
class TicketDepartment extends \yii\db\ActiveRecord
    {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نوع درخواست',
        ];
    }

    /**
     * @inheritdoc
     * @return TicketDepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketDepartmentQuery(get_called_class());
    }

    }
