<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccounts */

$this->title = 'ویرایش حساب بانکی ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'حساب بانکی', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="marginRL">
    <hr/>
    <div class="bank-accounts-update">

        <h1><?= Html::encode($model->id) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
