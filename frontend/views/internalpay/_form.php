<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InternalPay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="internal-pay-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'website_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_tell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website_desc')->textInput(['maxlength' => true]) ?>
    <?php
    $items = ArrayHelper::map(\common\models\WebsiteCategory::find()->all(), 'id', 'name');
    ?>

    <?= $form->field($model, 'website_categoryID')->dropDownList($items)->label('گروه کسب و کار') ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
