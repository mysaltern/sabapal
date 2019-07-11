<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccountsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-accounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'shaba') ?>

    <?= $form->field($model, 'cartNumber') ?>

    <?= $form->field($model, 'accountNumber') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'userID') ?>

    <?php // echo $form->field($model, 'primary') ?>

    <?php // echo $form->field($model, 'month') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
