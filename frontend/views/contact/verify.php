
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MobilePhone */
/* @var $form ActiveForm */
?>
<div class="container">
    <hr/>
    <div class="mobile">
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

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'token') ?>
        <?php
        $url = \yii\helpers\Url::to(['contact/resend']);
        ?>
        <div class="form-group">
            <a href="<?= $url ?>" >ارسال دوباره رمز </a>
        </div>
        <div class="form-group">
            <?= Html::submitButton('ثبت', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div><!-- mobile -->
</div>
