<?php

use yii\helpers\Html;
use yii\grid\GridView;

Yii::$app->formatter->locale = 'fa_IR@calendar=persian';
Yii::$app->formatter->calendar = \IntlDateFormatter::TRADITIONAL;
//Yii::$app->formatter->timeZone = 'UTC';
$value = 1451606400; // Fri, 01 Jan 2016 00:00:00 (UTC)
/* @var $this yii\web\View */
/* @var $searchModel common\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تراکنش های مالی';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <?php
    if (!is_null(Yii::$app->session->getFlash('success')))
    {
        ?>

        <div class="contact-form">
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
    if (!is_null(Yii::$app->session->getFlash('faild')))
    {
        ?>

        <div class="contact-form">
            <div class="alert alert-warning">
                <?= Yii::$app->session->getFlash('faild'); ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="transaction-index">

        <h3 class="text-center"><?= Html::encode($this->title) ?></h3>
        <?php // echo $this->render('_search', ['model' => $searchModel]);     ?>

       
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-sm-3 col-xs-6 text-center p-2">
					 <?= Html::a('شارژ اعتبار ', ['create3'], ['class' => 'btn btn-success w-100 br-10']) ?>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6 text-center p-2">
					<?= Html::a('انتقال داخلی وجه', ['transfer'], ['class' => 'btn btn-success w-100 br-10']) ?>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6 text-center p-2">
					<?= Html::a('درخواست تسویه', ['clearing'], ['class' => 'btn btn-success w-100 br-10']) ?>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6 text-center p-2">
					 <?= Html::a('درخواست وجه', ['request'], ['class' => 'btn btn-success w-100 br-10']) ?>
				</div>
			</div>
		</div>
       


        <div class="contact-form">
            <div class="alert alert-info br-10">
                <p>موجودی شما :<strong> <?php echo $money; ?></strong> ریال</p>
            </div>
        </div>

        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'userID',
//            'sourceTypeID',
                    'sourceType.name',
//            'sourceID',
//            'date',
                    [
                        'attribute' => 'date',
                        'contentOptions' => ['style' => 'width: 155px;'],
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                        'format' => 'raw',
                        'value' => function($model, $key, $index)
                        {
                            if (isset($model->date))
                            {

//                        $username = dektrium\user\models\User::find()->select('username')->where(['id' => $model->user_id])->asArray()->one();
//                        $txtStatus = Yii::$app->ReadHttpHeader->txtStatus($model->status);
//                        $time = Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->date]);
                                $time = Yii::$app->formatter->asDate($model->date, 'php:Y:m:d');
                                return $time;
                            }
                        },
                    ],
                    'amount',
                    [
                        'attribute' => 'فرستنده یا گیرنده',
                        'contentOptions' => ['style' => 'width: 155px;'],
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                        'format' => 'raw',
                        'value' => function($model, $key, $index)
                        {

                            if ($model->sourceTypeID == 3 or $model->sourceTypeID == 2)
                            {

                                $username = dektrium\user\models\User::find()->select('username')->where(['id' => $model->sourceID])->asArray()->one();

                                return $username['username'];
                            }
							
							if($model->sourceTypeID ==1)
							{
								 return  "شارژ کیف پول";
							}
							if($model->status !=1)
							{
								 return  "نا موفق";
							}
							//پرداخت از طریق کیف پول
							if($model->sourceTypeID ==8)
							{
								  $username = dektrium\user\models\User::find()->select('username')->where(['id' => $model->sourceID])->asArray()->one();

                                return $username['username'];
								 
							}
							// دریافت از کیف پول

							if($model->sourceTypeID ==9)
							{
								  $username = dektrium\user\models\User::find()->select('username')->where(['id' => $model->sourceID])->asArray()->one();

                                return $username['username'];
								 
							}
                            else
                            {
                                return $model->sourceID;
                            }
                        },
                    ],
                // 'bankLogID',
                // 'status',
                // 'notes',
                // 'cck',
//            ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
