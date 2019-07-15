<?php


use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\Wagedetail */

?>
<div class="wagedetail-view">

    <?=

    DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            //  'wage_id',
                [
                'attribute' => 'wage name',
                'value' => function ($model)
                    {
                    $name = common\models\Wage::find()->asArray()->where(['id' => $model->wage_id])->one();
                    return $name['name'];
                    }
            //  'visible' => \Yii::$app->user->can('posts.owner.view'),
            ],
            'fixpercent',
            'varpercent',
            // 'date',
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
            'startprice',
            'endprice',
        ],
    ])

    ?>

</div>
