<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InternalpaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'درگاه پرداخت';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <?php
    if (!is_null(Yii::$app->session->getFlash('close'))) {
        ?>

        <div class="contact-form">
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('close'); ?>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
    if (!is_null(Yii::$app->session->getFlash('success'))) {
        ?>

        <div class="contact-form">
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="internal-pay-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

        <p>
            <?= Html::a('ساخت درگاه پرداخت جدید', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="table-responsive">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function($model) {
//                    if ($model->id % 2 == 1)
                    {
                        return ['class' => 'fancy'];
                    }
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'userID',
                    'website_name',
                    'website_url:url',
                    'customer_tell',
                    [
//                    'attribute' => 'yii\grid\ActionColumn',
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['class' => 'text-c'],
                        'headerOptions' => ['class' => 'text-h']
                    ],
                // 'website_desc',
                // 'website_categoryID',
                // 'ip',
                // 'active',
                // 'deleted',
                // 'date',
                // 'private_code',
//                ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
