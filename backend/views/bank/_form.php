<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-accounts-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $items = array('' => 'تنظیم نشده', 1 => 'فعال', 2 => 'غیر فعال');
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shaba')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cartNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'userID')->textInput() ?>

    <?= $form->field($model, 'primary')->textInput() ?>

    <?= $form->field($model, 'month')->textInput() ?>

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
