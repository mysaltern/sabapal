<?php

use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\InternalPay */
?>
<div class="internal-pay-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'website_name',
            'website_url:url',
            'customer_tell',
            'website_desc',
//            'website_categoryID',
            [
                'attribute' => 'website_categoryID',
                'label' => 'دسته بندی سایت',
//        'header' => 'summary',
//        'filter' => ['1' => 'فعال', '0' => 'غیر فعال'],
                'format' => 'raw',
                'value' => function($model)
                {
                    $category = \common\models\WebsiteCategory::find()->where(['id' => $model->website_categoryID])->asArray()->one();


                    return $category['name'];
                },
            ],
            'ip',
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
//            'deleted',
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
            'private_code',
        ],
    ])
    ?>
	
	
	<?php
	$url = URL::to(['internalpay/connect','type'=>5,'id'=>$model->id]);
	?>
<div><a href="<?php echo $url ;?>">ثبت در شاپرک</a></div>
</div>
