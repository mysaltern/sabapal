<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>

<div class="row">

    <div class="col-lg-6">
        <div class="row">
            <label>شماره فاکتور</label>
            <input value="<?= $factor['factorNumber'] ?>"  disabled type="text" />
        </div>
        <div class="row">
            <label> نام و نام خانوادگی</label>
            <input value="<?= $factor['name'] . ' ' . $factor['lastname'] ?>"  disabled type="text" />
        </div>
        <div class="row">
            <label>پست الکترونیکی </label>
            <input value="<?= $factor['email'] ?>"  disabled type="text" />
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <label>تاریخ فاکتور</label>
            <input value="<?= $factor['status'] ?>"   disabled type="text" />
        </div>
        <div class="row">
            <label>شماره تلفن همراه </label>
            <input value="<?= $factor['mobile'] ?>"   disabled type="text" />
        </div>
    </div>

</div>

<hr/>

<div class="row">
    <div class="transaction-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="col-lg-4">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <br/>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?= $form->errorSummary($model) ?>
        <?php ActiveForm::end(); ?>

    </div>

</div>
