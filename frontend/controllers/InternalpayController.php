<?php

namespace frontend\controllers;

use Yii;
use common\models\InternalPay;
use common\models\Log;
use common\models\InternalpaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\httpclient\Client;

/**
 * InternalpayController implements the CRUD actions for InternalPay model.
 */
class InternalpayController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                        [
                        'actions' => ['index', 'create','xml', 'view', 'delete', 'update','result','index2','index3','index4','index5','index6','index7','json'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action)
                {
                    if (\Yii::$app->user->can('@'))
                    {

                    }
                    else
                    {
                        return $action->controller->redirect(Url::to(['user/login']));
                    }
                },
            ],
        ];
    }

    /**
     * Lists all InternalPay models.
     * @return mixed
     */
    public function actionIndex()
    {
		
	//	$a=$_SERVER['SERVER_ADDR'];
//var_dump($a);
//die;           
	    $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;
		$searchModel->active =1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	
 
			//	$urlSmall=	Yii::$app->params['baseURlEND'];
			//	$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
			//$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 5, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }    public function actionIndex2()
    {
		
		//تغییر شبای نمایندگی
            $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	 
 
			//	$urlSmall=	Yii::$app->params['baseURl'];
			//	$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
					$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 6, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    } public function actionIndex3()
    {
		
		//غیر فعال سازی پایانه
            $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	 
 
				$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
					$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 7, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
	 public function actionIndex4()
    {
		
		// تعریف مشتری و فروشگاه
            $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	 
 
				$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
					$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 13, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    } public function actionIndex5()
    {
		
		// اصلاح اطلاعات
            $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	 
 
				$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
					$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 14, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }public function actionIndex6()
    {
		
		// تغییر فروشگاه
       $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	 
 
				$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
					//$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 17, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
	public function actionIndex7()
    {
		
		// فعال سازی مجدد پایانه
            $searchModel = new InternalpaySearch();
        $searchModel->userID = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         	 
 
				$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['saveURL'];
			//		$sec =  Yii::$app->data->security();
					$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 18, $webservice = true);
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
	public function actionResult()
    {
		//102012362830659
		//107321965219776
		
		
		//new
		//107310683512696
		//104250131205120
		
		//
		/*
		12 gir karde
		104250131205120
		
		*/
		// در خواست پیگیری
            $searchModel = new InternalpaySearch();
			$searchModel->userID = Yii::$app->user->id;

			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

 
  
			//		$sec =  Yii::$app->data->security();
			//	$log = Log::create( Yii::$app->user->id, 'internal_pay', 1, 18, $webservice = true);
	 
	// $requestDate= array("2018-12-29","2018-12-30");
	 // $requestTypes= array('5');
	//	  $statuses= array('12');
	//100975187372351
	//105825109622066
	$trackingNumbers= array('100975187372351');
	  //  $trackingNumberPsps= array("11111111");
	 
	 $sec = Yii::$app->Data->security();
	 
	  $test = array('trackingNumbers'=> $trackingNumbers);
//$test = json_encode($test);
  
 
 
 
 
			//	$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['resultURL'];




		$urlSmall=	Yii::$app->params['baseURlEND'];
		 $secEND = Yii::$app->Data->securityEND();
			 
		
		$client = new Client();
		$response = $client->createRequest()
		->setFormat(Client::FORMAT_JSON)
	    ->setMethod('POST')
		->setUrl("$urlSmall$urlLarge")
		->addHeaders(['Authorization' => "Basic $secEND"])
	    ->setData(	$test)
 
	 //   ->setData(		[$test ] 	 	 )
    ->send();
	
 //var_dump("$urlSmall$urlLarge");
 //die;
var_dump($response->content);
die;
		
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionJson()
    {
		
		$shaparak =   \common\models\ShaparakDetails::find()->where('status=0')->asArray()->all();
		
		foreach($shaparak as $sh)
		{
	 	$id = $sh['id']; 
		$sheba = $sh['DbtrIdTp'];
		$shebaMasoodi = $sh['CdtrAcct'];
		$amount = $sh['IntrBkSttlmAmt'];
	 
		$acceptorCode = substr($sh['InstrId'], -15);
		 
		
		$arr = array('wage'=>0,"amount"=>$amount,"sheba"=>$sheba,'iin'=>'581672061','acceptorCode'=>"$acceptorCode",'shebaMasdoodi'=>$shebaMasoodi);
		 $sec = Yii::$app->ReadHttpHeader->jsonTransaction($arr);
		 
		 
		 
		   Yii::$app->db->createCommand()
                ->update('shaparak_details', ['status' => 1], "id  =$id")
                ->execute();
		 
		 die;
		}
	die;
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
    /**
     * Displays a single InternalPay model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InternalPay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		
		/*
		$merchant =  Yii::$app->data->merchent(\Yii::$app->user->id);
		
			
			
			$trackingNumberPsp = "111111111111111";
			$requestType="5";
			$urlSmall=	Yii::$app->params['baseURl'];
				$urlLarge=	Yii::$app->params['resultURL'];
					$sec =  Yii::$app->data->security();
			
		$client = new Client();
$response = $client->createRequest()
 ->setFormat(Client::FORMAT_JSON)
    ->setMethod('POST')
    ->setUrl("$urlSmall/$urlLarge")
    ->addHeaders(['Authorization' => "Basic $sec"])
	    ->setData([  
      //  'requestDate' => 'Yii',
      //   'requestTypes' => 'Yii',
    //	'statuses' => 'Yii',
		//	 'trackingNumbers' => 'Yii',
		//	  'trackingNumberPsps' => 'Yii',
						  
		])
    ->send();
if ($response->isOk) {
    // use your data
}
	*/
//var_dump($response);
//die;
	 
        $model = new InternalPay();
        $auth = \Yii::$app->authManager;
        if (!\Yii::$app->user->can('bankAccount'))
        {



            \Yii::$app->getSession()->setFlash('close', 'لطفا ابتدا حساب بانکی خود را وارد کنید .');
            return $this->redirect(['bankaccounts/create']);
            exit;
        }
        if (!\Yii::$app->user->can('mobile'))
        {
            \Yii::$app->getSession()->setFlash('close', 'لطفا ابتدا موبایل خود را وارد کنید');
            return $this->redirect(['contact/mobile']);
            exit;
        }
        if (!\Yii::$app->user->can('user2'))
        {
            \Yii::$app->getSession()->setFlash('close', 'لطفا ابتدا اطلاعات  خود را وارد کنید .');
            return $this->redirect(['contact/create']);
            exit;
        }
        if (!\Yii::$app->user->can('document'))
        {
            $checkMadarek = \common\models\UserConfirmatory::find()->select('id')->asArray()->where(['userID' => \Yii::$app->user->id, 'active' => null])->one();
            if (isset($checkMadarek['id']))
            {
                \Yii::$app->getSession()->setFlash('close', 'مدارک شما ارسال شده . لطفا تا زمان تایید توسط ما منتظر بمانید یا درصورت نیاز به اصلاح دوباره ارسال کنید.');
                return $this->redirect(['document/file']);
                exit;
            }
            else
            {
                \Yii::$app->getSession()->setFlash('close', 'لطفا ابتدا مدارک  خود را آپلود کنید  .');
                return $this->redirect(['document/file']);
                exit;
            }
        }

        if ($model->load(Yii::$app->request->post()))
        {
            $model->userID = \Yii::$app->user->id;

            $model->deleted = 0;
            $model->date = time();

            $model->save(false);
			
			
			
			
		$urlSmall=	Yii::$app->params['saveURL'];
			
			
			$trackingNumberPsp = "111111111111111";
			$requestType="5";
			$merchant =  Yii::$app->data->merchent($model->userID,5);
		//	$contact =   Yii::$app->data->contact($model->userID);
			//var_dump($merchant);
		//	die;
			
			
            \Yii::$app->getSession()->setFlash('success', 'درخواست اضافه کردن درگاه شما ارسال شد . بعد از تایید توسط ما میتوانید از آن استفاده کنید');
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InternalPay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {

            if ($model->active == 1)
            {
                \Yii::$app->getSession()->setFlash('close', 'بعد از تایید  درگاه شما توانایی تغییر آن رو ندارید ');
                return $this->redirect(['index']);
                die;
            }
		if($model->userID ==Yii::$app->user->id)
		{
					$model->save(false);
		}
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }
    public function actionXml()
    {
        $base = Yii::getAlias('@frontend/web/files/xml.xml');
        $url = "$base";
        $data = Yii::$app->Data->xml($url);
        $head = $data['head'];

        $content = $data['content'];

        \common\models\ShaparakList::saving($data);


/*
        return $this->render('xml', [
                        //     'searchModel' => $searchModel,
                        //         'dataProvider' => $dataProvider,
        ]);
		*/
    }

    /**
     * Deletes an existing InternalPay model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
            // $this->findModel($id)->delete();
        Yii::$app->Security->updateRecord("internal_pay",$id,2);

        return $this->redirect(['index']);
    }

    /**
     * Finds the InternalPay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InternalPay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InternalPay::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
