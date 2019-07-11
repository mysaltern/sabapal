<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if (!is_null(Yii::$app->session->getFlash('close')))
    {
    ?>

    <div class="contact-form">
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('close'); ?>
        </div>
    </div>
    <?php
    }
?>
<div class="ticket-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <div class="col-lg-6">
        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">


        <?php
        $item = array(
            "1" => "بالا",
            "2" => "متوسط",
            "3" => "پایین",
        );
        ?>
        <?= $form->field($model, 'order')->dropDownList($item);
        ?>

    </div>
    <div class="col-lg-6">


        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    </div>
    <div class="col-lg-6">

        <?=
                $form->field($model, 'ticketDepartmentID')
                ->dropDownList(
                        ArrayHelper::map(\common\models\TicketDepartment::find()->asArray()->all(), 'id', 'name')
                )
        ?>
    </div>

    <div class="col-lg-12">


        <?php
        echo $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/zip'],
        ]);
        ?>

    </div>
    <hr/>

    <br/>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
