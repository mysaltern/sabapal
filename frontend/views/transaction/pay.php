<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'پرداخت شارژ ماهیانه';
?>

<div id="charg-shahrak" class="marginRL">
    <hr/>
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
	
	 <h3 class="text-center"><?= Html::encode($this->title) ?></h3>
     <h4 class="text-center">شرکت شهرک های صنعتی</h4>
    <div class="contact-form">
        <div class="alert alert-info br-10">
            <p class="text-center">مبلغ : <?php echo $money; ?> ریال</p>
            <p class="text-center">گیرنده : <?php echo $goal; ?></p>
        </div>
    </div>

    <div class="transaction-form">

        <?php $form = ActiveForm::begin(); ?>


        <?php echo $form->field($model, 'goal')->hiddenInput(['value' => 1])->label(false); ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'رفتن به صفحه پرداخت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success w-100-d br-10' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
