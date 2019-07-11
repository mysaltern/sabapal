<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccounts */

$this->title = 'اضافه کردن حساب بانکی';
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="bank-accounts-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
