<?php

namespace frontend\controllers;

class ProductController extends \yii\web\Controller
{

    public function actionIndex()
    {

        $insta = \InstagramScraper\Instagram::withCredentials('miladpro', "momibs450Asada2@");

        $insta->login();
        $account = $insta->getMediasFromFeed("ho3einroshan");
        var_dump($account);
        die;

        $this->layout = 'sell';

        return $this->render('index');
    }

    public function actionOther()
    {
        $this->layout = 'sell';

        return $this->render('other');
    }

}
