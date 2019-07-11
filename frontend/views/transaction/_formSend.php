<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if (!is_null(Yii::$app->session->getFlash('faildTrancaction')))
    {
    ?>

    <div class="contact-form">
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('faildTrancaction'); ?>
        </div>
    </div>
    <?php
    }
?>
<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>


  <?= $form->field($model, 'amount')->textInput() ?>
  <?= $form->field($model, 'mobile')->textInput() ?>


    <div id="qr-page" class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ارسال' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success w-100-d br-10' : 'btn btn-primary']) ?>
    </div>
    <?= $form->errorSummary($model) ?>
    <?php ActiveForm::end(); ?>

</div>
