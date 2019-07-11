<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-accounts-form">

    <?php $form = ActiveForm::begin(); ?>
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
    <div class="col-lg-5">

        <?= $form->field($model, 'shaba')->textInput(['maxlength' => true, 'placeholder' => 'شماره شبا بدون IR وارد شود']) ?>
    </div>
    <div class="col-lg-1 hidden-sm hidden-md">
        <label class="txtIR">IR-</label>

    </div>

    <div class="col-lg-6">

        <?= $form->field($model, 'cartNumber')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-3">

        <?= $form->field($model, 'year')->textInput() ?>


    </div>
    <div class="col-lg-3">

        <?= $form->field($model, 'month')->textInput() ?>
    </div>
    <div class="col-lg-3">

        <?= $form->field($model, 'accountNumber')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-3">
        <?php
        $item = array(0 => 'نباشد', 1 => 'باشد')
        ?>
        <?= $form->field($model, 'primary')->dropDownList($item) ?>


    </div>
    <!--<div class="col-lg-12">-->
    <br/>
    <div class="col-lg-3">
        <?php
        $items = ArrayHelper::map(\common\models\BankList::find()->all(), 'id', 'name');
        ?>

        <?= $form->field($model, 'bankID')->dropDownList($items)->label('نام بانک') ?>

    </div>
    <br/>
    <div class="space"></div>
    <!--</div>-->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
