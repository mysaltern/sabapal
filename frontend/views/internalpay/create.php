<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InternalPay */

$this->title = 'ساخت درگاه  پرداخت';
$this->params['breadcrumbs'][] = ['label' => 'Internal Pays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="internal-pay-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
<div class="clearfix"></div>