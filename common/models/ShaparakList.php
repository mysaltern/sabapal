<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shaparak_list".
 *
 * @property integer $id
 * @property string $MsgId
 * @property string $CrDtTm
 * @property integer $NbOfTxs
 * @property string $TtlIntrBkSttlmAmt
 * @property string $IntrBkSttlmDt
 * @property string $SttlmInf
 * @property string $PmtTpInf
 *
 * @property ShaparakDetails[] $shaparakdetails
 */
class ShaparakList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shaparak_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NbOfTxs'], 'integer'],
            [['MsgId', 'TtlIntrBkSttlmAmt', 'IntrBkSttlmDt', 'SttlmInf', 'PmtTpInf'], 'string', 'max' => 50],
            [['CrDtTm'], 'string', 'max' => 19],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'MsgId' => 'Msg ID',
            'CrDtTm' => 'Cr Dt Tm',
            'NbOfTxs' => 'Nb Of Txs',
            'TtlIntrBkSttlmAmt' => 'Ttl Intr Bk Sttlm Amt',
            'IntrBkSttlmDt' => 'Intr Bk Sttlm Dt',
            'SttlmInf' => 'Sttlm Inf',
            'PmtTpInf' => 'Pmt Tp Inf',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShaparakdetails()
    {
        return $this->hasMany(ShaparakDetails::className(), ['shaparakListID' => 'id'])->inverseOf('shaparaklist');
    }
	
	
		  public static function saving( $array)
    {
      $content = $array['content'];
	  $head = $array['head'];
	  
 
        $model = new ShaparakList(); 
		
		$model->MsgId=$head['GrpHdr']['MsgId'];
		$model->CrDtTm=$head['GrpHdr']['CreDtTm'];
		$model->NbOfTxs=$head['GrpHdr']['NbOfTxs'];
		$model->TtlIntrBkSttlmAmt=$head['GrpHdr']['TtlIntrBkSttlmAmt'];
		$model->IntrBkSttlmDt=$head['GrpHdr']['IntrBkSttlmDt'];
		$model->SttlmInf=$head['GrpHdr']['SttlmInf']['SttlmMtd'];
		$model->PmtTpInf=$head['GrpHdr']['PmtTpInf']['SvcLvl']['Cd'];
        $model->save(false);
		 
		  $id = $model->id;
		  
		  
		    $ShaparakDetails= new \common\models\ShaparakDetails();
			
			foreach($content as $c)
			{
						 $ShaparakDetails->saving($id,$c);	
			}

		       

		
      
    }
}
