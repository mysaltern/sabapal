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
        'attribute' => 'sourceTypeID',
        'header' => 'نوع',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
        'format' => 'raw',
        'value' => function($model, $key, $index)
        {
//            $category = app\models\PostTags::find()->where(['post_id' => $model->id])->innerJoinWith('tag', 'tag.id = T.tag_id')->asArray()->all();
            $category = \common\models\Sourcetypes::find()->where(['id' => $model->sourceTypeID])->asArray()->all();

            $tag = '';

            foreach ($category as $cat)
            {
                $t = $cat['name'];


                $tag .= "$t ";
            }

            return $tag;
        },
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'sourceID',
    ],
        [
        'attribute' => 'status',
        'header' => 'وضعیت',
        'format' => 'raw',
        'value' => function($model, $key, $index)
        {

            $status = Yii::$app->ReadHttpHeader->settlement($model->status);


            return $status;
        },
    ],
//        [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'date',
//    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'amount',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'bankLogID',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'token',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'notes',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'cck',
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
