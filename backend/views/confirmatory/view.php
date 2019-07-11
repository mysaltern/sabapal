<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserConfirmatory */
?>
<div class="user-confirmatory-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'nationalCard_url:url',
            [
                'attribute' => 'nationalCard_url',
                'value' => function($model)
                {
                    $nationalCard_url = $model->nationalCard_url;
                    $host = Yii::$app->params['uploadPath'];

                    return $host . '/' . $nationalCard_url;
                },
                'format' => ['image', ['width' => '100', 'height' => '100']],
            ],
//            'birthCertificate_url:url',
            [
                'attribute' => 'birthCertificate_url',
                'value' => function($model)
                {
                    $birthCertificate_url = $model->birthCertificate_url;
                    $host = Yii::$app->params['uploadPath'];

                    return $host . '/' . $birthCertificate_url;
                },
                'format' => ['image', ['width' => '100', 'height' => '100']],
            ],
                [
                'attribute' => 'userID',
                'label' => 'نام کاربری',
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                'format' => 'raw',
                'value' => function($model)
                {
                    $category = \common\models\User::find()->where(['id' => $model->userID])->asArray()->one();


                    return $category['username'];
                },
            ],
                [
                'attribute' => 'active',
                'label' => 'وضعیت',
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                'format' => 'raw',
                'value' => function($model)
                {
                    if ($model->active == 1)
                    {
                        return "فعال";
                    }
                    else
                    {
                        return 'غیر فعال';
                    }
                },
            ],
        ],
    ])
    ?>

</div>
