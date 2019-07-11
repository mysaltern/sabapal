<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'amount')->textInput() ?>



    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>
    <?php
    $items = array('0' => 'تایید نشده', '2' => 'در حال انجام', '3' => 'پرداخت شده');
    ?>
    <?php
    echo $form->field($model, 'status')
            ->dropDownList(
                    $items // Flat array ('id'=>'label')
                    // options
    );
    ?>


    <?php
    if (!Yii::$app->request->isAjax)
    {
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
