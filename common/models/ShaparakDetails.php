<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shaparak_details".
 *
 * @property integer $id
 * @property string $PmtTpInf
 * @property string $InstrId
 * @property string $EndToEndId
 * @property string $TxId
 * @property string $IntrBkSttlmAmt
 * @property string $ChrgBr
 * @property string $Nm
 * @property string $DbtrId
 * @property string $DbtrIdTp
 * @property string $DbtrAcct
 * @property string $DbtrAgt
 * @property string $CdtrAgt
 * @property string $Cdtr
 * @property string $PrvtId
 * @property string $CdtrAcct
 * @property string $RmtInf
 * @property integer $shaparakListID
 * @property integer $internalID
 *
 * @property ShaparakList $shaparaklist
 * @property InternalPay $internal
 */
class ShaparakDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shaparak_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shaparakListID','status', 'internalID'], 'integer'],
            [['internalID'], 'required'],
            [['PmtTpInf', 'InstrId', 'EndToEndId', 'TxId', 'IntrBkSttlmAmt', 'ChrgBr', 'Nm', 'DbtrId', 'DbtrIdTp', 'DbtrAcct', 'DbtrAgt', 'CdtrAgt', 'Cdtr', 'PrvtId', 'CdtrAcct', 'RmtInf'], 'string', 'max' => 50],
            [['shaparakListID'], 'exist', 'skipOnError' => true, 'targetClass' => ShaparakList::className(), 'targetAttribute' => ['shaparakListID' => 'id']],
            [['internalID'], 'exist', 'skipOnError' => true, 'targetClass' => InternalPay::className(), 'targetAttribute' => ['internalID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'PmtTpInf' => 'Pmt Tp Inf',
            'InstrId' => 'Instr ID',
            'EndToEndId' => 'End To End ID',
            'TxId' => 'Tx ID',
            'IntrBkSttlmAmt' => 'Intr Bk Sttlm Amt',
            'ChrgBr' => 'Chrg Br',
            'Nm' => 'Nm',
            'DbtrId' => 'Dbtr ID',
            'DbtrIdTp' => 'Dbtr Id Tp',
            'DbtrAcct' => 'Dbtr Acct',
            'DbtrAgt' => 'Dbtr Agt',
            'CdtrAgt' => 'Cdtr Agt',
            'Cdtr' => 'Cdtr',
            'PrvtId' => 'Prvt ID',
            'CdtrAcct' => 'Cdtr Acct',
            'RmtInf' => 'Rmt Inf',
            'status' => 'status',
            'shaparakListID' => 'Shaparak List I D',
            'internalID' => 'Internal I D',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShaparaklist()
    {
        return $this->hasOne(ShaparakList::className(), ['id' => 'shaparakListID'])->inverseOf('shaparakdetails');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternal()
    {
        return $this->hasOne(InternalPay::className(), ['id' => 'internalID'])->inverseOf('shaparakdetails');
    }
	  public static function saving($id, $array)
    {
   
        $model = new ShaparakDetails();
	//	$model->PmtTpInf = $array['PmtId']['EndToEndId'];
		$model->InstrId = $array['PmtId']['InstrId'];
        $model->EndToEndId = $array['PmtId']['EndToEndId'];
        $model->TxId = $array['PmtId']['TxId'];
        $model->IntrBkSttlmAmt = $array['IntrBkSttlmAmt'];
        $model->ChrgBr = $array['ChrgBr'];
        $model->Nm = $array['Dbtr']['Nm'];
        $model->DbtrId = $array['Dbtr']['Id']['PrvtId']['OthrId']['Id'];
       $model->DbtrIdTp = $array['DbtrAcct']['Id']['IBAN'];
      /*   $model->DbtrAcct = $array['PmtId']['EndToEndId'];
        $model->DbtrAgt = $array['PmtId']['EndToEndId'];
        $model->CdtrAgt = $array['PmtId']['EndToEndId'];
        $model->Cdtr = $array['PmtId']['EndToEndId'];
        $model->PrvtId = $array['PmtId']['EndToEndId'];
		*/
        $model->CdtrAcct = $array['CdtrAcct']['Id']['IBAN'];
        $model->RmtInf = $array['RmtInf']['Ustrd'];
        $model->shaparakListID = $id;
		
		
		$char = substr($model->InstrId, -15);
		$internal =  new \common\models\InternalPay();
		$internalID = $internal->getID($char);
	 
         $model->internalID ="$internalID";
         
        $model->save(false);
        return true;
    }
	
	

}
