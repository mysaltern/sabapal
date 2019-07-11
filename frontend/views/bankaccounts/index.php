<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BankAccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'حساب های بانکی';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="bank-accounts-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('اضافه کردن حساب جدید', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="table-responsive">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//            'id',
                    'bank.name',
                    'shaba',
                    'cartNumber',
                    'accountNumber',
                    // 'status',
                    // 'year',
                    // 'userID',
                    // 'primary',
                    // 'month',
//                ['class' => 'yii\grid\ActionColumn'],
                    [
//                    'attribute' => 'yii\grid\ActionColumn',
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['class' => 'text-c'],
                        'headerOptions' => ['class' => 'text-h']
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
