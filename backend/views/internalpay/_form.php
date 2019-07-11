<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\InternalPay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="internal-pay-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $items = array('1' => 'فعال', '2' => 'غیر فعال');
    ?>
    <?php // echo $form->field($model, 'userID')->textInput() ?>

    <?= $form->field($model, 'website_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_tell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website_desc')->textInput(['maxlength' => true]) ?>

    <?php
    $items = ArrayHelper::map(\common\models\WebsiteCategory::find()->all(), 'id', 'name');
    ?>

    <?= $form->field($model, 'website_categoryID')->dropDownList($items)->label('گروه کسب و کار') ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'private_code')->textInput(['maxlength' => true]) ?>
    <?php
    $items = array('1' => 'فعال', '2' => 'غیر فعال');
    ?>
    <?php
    echo $form->field($model, 'active')
            ->dropDownList(
                    $items // Flat array ('id'=>'label')
                    // options
    );
    ?>
    <?php // echo $form->field($model, 'deleted')->textInput()   ?>

    <?php // echo $form->field($model, 'date')->textInput()   ?>


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
