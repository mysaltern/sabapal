<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Factor */
?>
<div class="factor-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'lastname',
            'factorNumber',
            'url:url',
            'dateFactor',
            'mobile',
            'email:email',
            'money',
            'status',
            'user_id',
        ],
    ]) ?>

</div>
