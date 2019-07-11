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
        'attribute' => 'userID',
        'header' => 'نام کاربری',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
        'format' => 'raw',
        'value' => function($model, $key, $index)
        {
            $category = \common\models\User::find()->where(['id' => $model->userID])->asArray()->one();


            return $category['username'];
        },
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'website_name',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'website_url',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'customer_tell',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'website_desc',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'website_categoryID',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'ip',
    // ],
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
            }  if ($model->active == '2')
            {
                return '<div class="alert alert-warning"> درخواست غیر فعال کردن</div>';
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
    // 'attribute'=>'deleted',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'date',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'private_code',
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
