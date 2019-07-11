<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserConfirmatory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-confirmatory-form">
    <?php
    $items = array('1' => 'فعال', '2' => 'غیر فعال');
    ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nationalCard_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthCertificate_url')->textInput(['maxlength' => true]) ?>

    <?php // echo  $form->field($model, 'userID')->textInput() ?>

    <?php
    echo $form->field($model, 'active')
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
