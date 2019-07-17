<?php

use yii\bootstrap\Html;
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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
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
                return 'غیرفعال';
            }
        },

    ],
  //  [
     //   'class'=>'\kartik\grid\DataColumn',
   //     'attribute'=>'erase',
  //  ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{wage}',


        'buttons' => ['view' => function($url, $model)
        {
            return Html::a('<span class = "btn btn-sm btn-default"><b class = "fa fa-search-plus"></b></span>', ['view', 'id' => $model['id']], ['title' => 'View', 'id' => 'modal-btn-view']);
        },


            'wage' => function($id, $model)
            {
                $wagedetail = "      <a class='btn btn-default waves-effect' href='../wagedetail/index?WagedetailSearch[wage_id]=$model->id' title='Wage Detail' role=''><i class='glyphicon glyphicon-th'></i></a>";
                return  $wagedetail;

            },
        ]
    ],

];