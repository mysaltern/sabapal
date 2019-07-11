<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccounts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="bank-accounts-view">

        <!--<h1><?php // echo  Html::encode($this->title)  ?></h1>-->

        <p>
            <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('حذف', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
                'bank.name',
                'shaba',
                'cartNumber',
                'accountNumber',
                'status',
                'year',
                'userID',
                'primary',
                'month',
                'deleted'
            ],
        ])
        ?>

    </div>
</div>
