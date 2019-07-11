<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\UserConfirmatory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-confirmatory-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?php
    if (!is_null(Yii::$app->session->getFlash('success')))
    {
        ?>

        <div class="contact-form">
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
        <?php
    }
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

    <?php
    echo $form->field($model, 'nationalCard_url')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]);
    ?>
    <?php
    echo $form->field($model, 'birthCertificate_url')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]);
    ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
