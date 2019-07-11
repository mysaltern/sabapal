<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">
    <?php
    if (!empty($ticket))
    {
        ?>

        <div class=" ">
            <div class="alert alert-info">
                <div class="container">
                    <div class="col-lg-12">

                        <div class="col-lg-6">


                            <label>نام کاربری ارسال کننده:</label>
                            <label>اکبر آقا بقال</label>

                        </div>


                        <div class="col-lg-6">

                            <label> تاریخ ارسال تیکت :</label>
                            <label>13/13/1370</label>


                        </div>
                        <div class="col-lg-6">


                            <label>آدرس فایل:</label>
                            <label><a href="<?= $ticket['file']; ?>" >دانلود </a></label>

                        </div>


                        <div class="col-lg-6">

                            <label>  موضوع درخواست :</label>
                            <label><?= $ticket['subject']; ?></label>


                        </div>
                        <div class="col-lg-6">

                            <?php
                            $category = \common\models\TicketDepartment::find()->where(['id' => $ticket['ticketDepartmentID']])->asArray()->one();
                            ?>
                            <label>دسته بندی درخواست : </label>
                            <label><?= $category['name']; ?></label>

                        </div>


                        <div class="col-lg-12">

                            <label> شرح موضوع : :</label>
                            <label><?= $ticket['description']; ?></label>


                        </div>

                    </div>


                </div>
            </div>
        </div>

        <?php
    }
    ?>
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?php
    if (!isset($_GET['id']))
    {
        echo $form->field($model, 'ticketDepartmentID')->textInput();
    }
    ?>

    <?php
    if (!isset($_GET['id']))
    {
        echo $form->field($model, 'file')->textInput(['maxlength' => true]);
    }
    ?>


    <?php
    if (!isset($_GET['id']))
    {
        echo $form->field($model, 'order')->textInput();
    }
    ?>
    <?php
    if (!isset($_GET['id']))
    {
        echo $form->field($model, 'type')->textInput();
    }
    ?>



    <?php
    if (!Yii::$app->request->isAjax)
    {
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
