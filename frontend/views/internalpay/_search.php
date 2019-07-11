<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InternalpaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="internal-pay-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userID') ?>

    <?= $form->field($model, 'website_name') ?>

    <?= $form->field($model, 'website_url') ?>

    <?= $form->field($model, 'customer_tell') ?>

    <?php // echo $form->field($model, 'website_desc') ?>

    <?php // echo $form->field($model, 'website_categoryID') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'private_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
