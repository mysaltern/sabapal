<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="marginRL">
    <hr/>
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

    <div class="contact-form">
        <div class="alert alert-info br-10">
            <p>موجودی شما :<strong> <?php echo $money; ?></strong> ریال</p>
        </div>
    </div>
    <div class="transaction-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'amount')->textInput() ?>
        <?= $form->field($model, 'goal')->textInput() ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'انتقال' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success w-100-d br-10' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
