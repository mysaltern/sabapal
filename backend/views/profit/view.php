<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profit */
?>
<div class="profit-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'percent',
          //  'method',

            [
                'attribute' => 'method',
                'value' => function ($model)
                {

                    if ($model->method == 0)
                    {
                        return 'کمترین موجودی حساب';
                    }
                    if ($model->method == 1)
                    {
                        return 'بالاترین موجودی حساب';
                    }
                    if ($model->method == 2)
                    {
                        return 'معدل حساب';
                    }
                },

            ],

        ],
    ]) ?>

</div>
