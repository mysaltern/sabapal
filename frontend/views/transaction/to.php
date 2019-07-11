<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */

$this->title = 'بارکدپرداخت';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="marginRL">
    <hr/>
    <div class="transaction-create">

        <h3 class="text-center"><?= Html::encode($this->title) ?></h3>
        <h4 class="text-center">دریافت کننده : <?= $info ?></h4>

        <?=
        $this->render('_formSend', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
