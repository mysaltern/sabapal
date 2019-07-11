<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view yekan">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?php
//    echo  DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'userID',
//            'subject',
//            'description',
//            'ticketDepartmentID',
//            'order',
//            'type',
//            'status',
//            'parent',
//            'date',
//            'deleted',
//        ],
//    ])
    ?>
    <div class="row size19">
        <div class="col-lg-6">
            <span>عنوان:</span>
            <span>درگاه پرداخت جدید</span>
        </div>
        <div class="col-lg-6 leftPage">
            <span>شماره تیکت :</span>
            <span> <?php echo $model->id; ?> </span>
        </div>
    </div>

    <div class="khat" ></div>

    <div class="col-lg-4">

        <p><strong>ایجادشده</strong></p>
        <?php
        $time = Yii::$app->formatter->asDate($model->date, 'php:Y:m:d');
        ?>

        <p class="tire"><?= $time ?></p>
    </div>
    <div class="col-lg-4">

        <p><strong>اولویت</strong></p>
        <p class="tire"><?php echo $txtOrder; ?></p>
        <?php
        ?>

    </div>

    <div class = "col-lg-4">

        <p><strong>وضعیت</strong></p>
        <p class = "tire"><?php echo $txtStatus; ?></p>


    </div>


    <div class = "col-lg-4">

        <p><strong>موضوع</strong></p>
        <p class = "tire"><?php echo $model->subject; ?></p>


    </div>

    <div class = "col-lg-4">

        <p><strong>توضیح</strong></p>
        <p class = "tire"><?php echo $model->description; ?></p>


    </div>

    <div class="khat" ></div>


    <?php
    foreach ($otherModel as $other)
    {
        $time = $other['date'];
        $subject = $other['subject'];
        $description = $other['description'];
        $file = $other['file'];
        $username = dektrium\user\models\User::findOne(['id' => $other['userID']])->username;
        ?>
        <?php
        $time = Yii::$app->formatter->asDate($time, 'php:Y:m:d');
        ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="col-lg-2">
                    <?php
                    if (!empty($file))
                    {
                        ?>
                        <a href="../<?php echo $file; ?>" >دانلود فایل ضمیمه</a>
                        <?php
                    }
                    ?>

                </div>


                <div class="col-lg-8">

                    <div class="col-lg-12">
                        <p>
                            <!--<span>نام</span>-->
                            <span>نام کاربری :</span>
                            <span><?php echo $username; ?>  </span>
                        </p>


                    </div>

                    <div class="col-lg-12">

                        <span>

                            <?php echo $description; ?></span>

                    </div>



                </div>
                <div class="col-lg-2">

                    <div class="col-lg-12">
                        <p>
                            <span><?= $time ?></span>

                        </p>


                    </div>


                </div>

            </div>
        </div>
        <div class="space"></div>

        <?php
    }
    ?>



</div>
