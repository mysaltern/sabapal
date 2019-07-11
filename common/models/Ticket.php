<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $userID
 * @property string $subject
 * @property string $description
 * @property integer $ticketDepartmentID
 * @property integer $order
 * @property string $type
 * @property string $file
 * @property integer $status
 * @property integer $parent
 * @property integer $date
 * @property integer $deleted
 *
 * @property User $user
 * @property User $ticketDepartment
 */
class Ticket extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['userID', 'ticketDepartmentID', 'order', 'status', 'parent', 'date', 'deleted'], 'integer'],
                [['subject', 'file', 'type'], 'string', 'max' => 255],
                [['description'], 'string', 'max' => 5000],
                [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
                [['ticketDepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ticketDepartmentID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'subject' => 'موضوع',
            'description' => 'توضیحات',
            'ticketDepartmentID' => 'نوع درخواست',
            'order' => 'اولویت',
            'type' => 'نوع',
            'status' => 'وضعیت',
            'file' => 'فایل ضمیمه',
            'parent' => 'Parent',
            'date' => 'Date',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketDepartment()
    {
        return $this->hasOne(TicketDepartment::className(), ['id' => 'ticketDepartmentID']);
    }

    /**
     * @inheritdoc
     * @return TicketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketQuery(get_called_class());
    }

    public static function updateType($id, $type, $status)
    {

        $connection = Yii::$app->db;

        $connection->createCommand()
                ->update('ticket', ['type' => $type, 'status' => $status], "id=$id")
                ->execute();

        return $connection;
    }

}
