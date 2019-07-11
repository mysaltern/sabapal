<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
?>
<div class="ticket-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'userID',
            'subject',
            'description',
            'ticketDepartmentID',
            'file',
            'order',
            'type',
            'status',
//            'parent',
            [
                'attribute' => 'date',
                'label' => 'تاریخ',
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                'format' => 'raw',
                'value' => function($model)
                {
                    if (isset($model->date))
                    {

                        Yii::$app->formatter->locale = 'fa_IR@calendar=persian';
                        Yii::$app->formatter->calendar = \IntlDateFormatter::TRADITIONAL;
                        Yii::$app->formatter->timeZone = 'UTC';

                        $t = Yii::$app->formatter->asDate($model->date, "yyyy-MM-dd / H:m:s");
                        return $t;
                    }
                },
            ],
//            'deleted',
        ],
    ])
    ?>

</div>
