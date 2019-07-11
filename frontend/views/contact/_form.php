<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

<?php $form = ActiveForm::begin(); ?>
<?php
if (!is_null(Yii::$app->session->getFlash('success')))
{
    ?>

        <div class="contact-form">
            <div class="alert alert-success">
    <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
                <?php
            }
            ?>
    <?php
    if (!is_null(Yii::$app->session->getFlash('close')))
    {
        ?>

        <div class="contact-form">
            <div class="alert alert-danger">
    <?= Yii::$app->session->getFlash('close'); ?>
            </div>
        </div>
                <?php
            }
            ?>
    <div class="col-lg-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">

<?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-6">

<?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'tell')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'postalCode')->textInput(['maxlength' => true]) ?>
    </div>
	<div class="col-lg-6">
        <?= $form->field($model, 'nationalCode')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
        <?php
        $items = array(0 => 'زن', 1 => 'مرد');
        ?>

        <?= $form->field($model, 'gender')->dropDownList($items) ?>
    </div>
        <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
