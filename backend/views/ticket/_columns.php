<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

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
//    [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'userID',
//    ],
    [
        'attribute' => 'userID',
        'header' => 'نام کاربری',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
        'format' => 'raw',
        'value' => function($model, $key, $index)
        {
//            $category = app\models\PostTags::find()->where(['post_id' => $model->id])->innerJoinWith('tag', 'tag.id = T.tag_id')->asArray()->all();
            $category = \common\models\User::find()->where(['id' => $model->userID])->asArray()->one();


            return $category['username'];
        },
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'subject',
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'description',
    ],
//        [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'ticketDepartmentID',
//    ],
    [
        'attribute' => 'ticketDepartmentID',
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
        'format' => 'raw',
        'value' => function($model, $key, $index)
        {
//            $category = app\models\PostTags::find()->where(['post_id' => $model->id])->innerJoinWith('tag', 'tag.id = T.tag_id')->asArray()->all();
            $category = \common\models\TicketDepartment::find()->where(['id' => $model->ticketDepartmentID])->asArray()->all();

            $tag = '';

            foreach ($category as $cat)
            {
                $t = $cat['name'];


                $tag .= "<span class = 'badge'>$t </span>";
            }

            return $tag;
        },
    ],
        [
        'attribute' => 'file',
        'header' => 'فایل',
        'format' => 'raw',
        'value' => function ($model)
        {


            $host = Yii::$app->params['uploadPath'];

            return Html::a("دانلود", "$host$model->file", ['target' => '_blank']);
        }
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'order',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'type',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'status',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'parent',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'date',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'deleted',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'template' => '{delete} {view} {update}{nini} {copy}',
        'urlCreator' => function($action, $model, $key, $index)
        {
            return Url::to([$action, 'id' => $key]);
        },
//        'buttons' => [
//            'nini' => function ($url, $model, $key)
//                {
//                return Html::a('<span class="glyphicon glyphicon-copy"></span>', ['/postcontent/index', 'id' => $model->id], ['title' => 'مدیا']);
//                },
//        ],
        'buttons' => [
            'nini' => function ($url, $model, $key)
            {

                $host = Yii::$app->params['backend'];

                $url = Url::to(['ticket/reply', 'id' => $model->id]);

//                return Html::a('<span role="modal-remote" data-toggle="tooltip" class="glyphicon glyphicon-transfer"></span></hr>', ['/ticket/create', 'id' => $model->id], ['title' => 'پاسخ به تیکت']);
                return Html::a('پاسخ به تیکت', "$url", ['class' => 'btn', 'target' => '_top', "onclick" => "window.open ('$url', ''); return false ", 'role' => '']);
            },
//            'copy' => function ($url, $model, $key)
//            {
//                $host = Yii::$app->params['uploadPath'];
//                $url = "";
//
//
//                return Html::a('باز کردن پست در سایت', "$host/post/$model->id-$url", ['class' => 'btn', 'target' => '_top', "onclick" => "window.open ('$host/post/$model->id-$url', ''); return false ", 'role' => '']);
//            },
        ],
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
