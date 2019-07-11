<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccounts */
?>
<div class="bank-accounts-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'shaba',
            'cartNumber',
            'accountNumber',
            'status',
            'year',
            'user.username',
            'primary',
            'month',
            'active',
            'time:datetime',
        ],
    ])
    ?>

</div>
