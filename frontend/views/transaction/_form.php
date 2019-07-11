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


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'پرداخت' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success br-10 w-100-d' : 'btn btn-primary']) ?>
    </div>
    <?= $form->errorSummary($model) ?>
    <?php ActiveForm::end(); ?>

</div>
