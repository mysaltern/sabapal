<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Wage */
?>
<div class="wage-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'active',
                'value' => function ($model)
                {

                    if ($model->active == 1)
                    {
                        return 'فعال';
                    }
                    if ($model->active == 0)
                    {
                        return 'غرفعال';
                    }
                },

            ],
          //  'erase',
        ],
    ]) ?>

</div>
