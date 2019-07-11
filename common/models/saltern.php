<?php

namespace common\models;

use Yii;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of function
 *
 * @author milad
 */
class saltern extends \yii\db\ActiveRecord
{

    public $username = "mysaltern";
    public $password = "momibs450Asada@";
    public $from = "50004000417687";

    public function actionText($sex, $name, $lastName, $text, $job)
    {


        if (strpos($text, '{نام}') !== FALSE)
        {

            $text = str_replace('{نام}', $name, $text);
        }
        if (strpos($text, '{نام خانوادگی}') !== FALSE)
        {

            $text = str_replace('{نام خانوادگی}', $lastName, $text);
        }
        if (strpos($text, '{شغل}') !== FALSE)
        {

            $text = str_replace('{شغل}', $job, $text);
        }
        if ($sex == 1)
        {


            $text = str_replace('{جنس}', 'آقای', $text);
        }
        if ($sex == 2)
        {


            $text = str_replace('{جنس}', 'خانم', $text);
        }

        return $text;
    }

    public static function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];


        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

}
