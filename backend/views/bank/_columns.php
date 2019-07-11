<?php

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
        'attribute' => 'name',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'shaba',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'cartNumber',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'accountNumber',
    ],
        [
        'attribute' => 'active',
//        'header' => 'Status',
        'filter' => ['1' => 'فعال', '0' => 'غیر فعال', '' => 'نا مشخص'],
        'format' => 'raw',
        'value' => function($model, $key, $index)
        {
            if ($model->active == '1')
            {
                return '<div class="alert alert-success">فعال </div>';
            }
            if ($model->active == '')
            {
                return '<div class="alert alert-danger">نا مشخص </div>';
            }
            else
            {
                return '<div class="alert alert-danger"> غیر فعال</div>';
            }
        },
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'year',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'userID',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'primary',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'month',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'active',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'time',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'deleted',
    // ],
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
