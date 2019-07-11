<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 
   $urlTest = Yii::$app->security->checkBlock($userID);
 
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\Query;

class Security extends Component
{

    public function checkSecurity($money, $userID, $ip, $cck, $type, $id)
    {
// $secretKey our application or user secret, $data obtained from an unreliable source
        $token = $userID * $id;

        $data = Yii::$app->getSecurity()->validateData($cck, $token);
 
 
        if ($data != false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function generate($userID, $money, $id)
    {
        $token = $userID * $id;
 
        $data = Yii::$app->getSecurity()->hashData($money, $token);
        return $data;
    }

    public function blockUser($userID)
    {
        Yii::$app->db->createCommand()
                ->update('user', ['blocked_at' => time()], "id = $userID")
                ->execute();
    }
	   public function updateRecord($table,$id,$value)
    {
        Yii::$app->db->createCommand()
                ->update("$table", ['active' => $value], "id = $id")
                ->execute();
    }
	public function checkBlock($userID)
	
	{
		   $user = \dektrium\user\models\User::find()->where("id=  $userID")->one();
			var_dump($user);
			die;
	}

}

?>