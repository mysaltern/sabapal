<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تیکت ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="ticket-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('ثبت تیکت', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'userID',
                'subject',
                'description',
//            'ticketDepartmentID',
                'ticketDepartment.name',
                [
                    'attribute' => 'وضعیت',
                    'contentOptions' => ['style' => 'width: 155px;'],
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                    'format' => 'raw',
                    'value' => function($model, $key, $index) {
                        if (isset($model->status)) {

//                        $username = dektrium\user\models\User::find()->select('username')->where(['id' => $model->user_id])->asArray()->one();
                            $txtStatus = Yii::$app->ReadHttpHeader->txtStatus($model->status);

                            return $txtStatus;
                        }
                    },
                ],
                // 'order',
                // 'type',
                // 'status',
                // 'parent',
                // 'date',
                // 'deleted',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
    </div>
</div>
<div class="clearfix"></div>
