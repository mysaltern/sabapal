<?php


use yii\helpers\ArrayHelper;
use yii\helpers\Url;


return [
        [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
        [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'wage',
        'value' => function ($model)
            {
            $name = \common\models\Wage::find()->select('name')->asArray()->where(['id' => $model->wage_id])->one();

            return $name['name'];
            },
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'fixpercent',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'varpercent',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'date',
//    ],
    [
        'attribute' => 'date',
        'value' => function ($model)
            {

            if ($model->date == 0)
                {
                return 'شنبه';
                }
            if ($model->date == 1)
                {
                return 'یکشنبه';
                }
            if ($model->date == 2)
                {
                return 'دوشنبه';
                }
            if ($model->date == 3)
                {
                return 'سه شنبه';
                }
            if ($model->date == 4)
                {
                return 'چهارشنبه';
                }
            if ($model->date == 5)
                {
                return 'شنبه۵';
                }
            if ($model->date == 6)
                {
                return 'جمعه';
                }
            },
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'startprice',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'endprice',
    ],
        [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function($action, $model, $key, $index)
            {
            return Url::to([$action, 'id' => $key]);
            },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],
];
