<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'ارتباط با ما';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="marginRL">

    <br/>
    <br/>

    <div class="site-contact">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            لطفا نظرات و انتقادات و پیشنهادات خودتان را از طریق فرم زیر برای ما ارسال کنید .
        </p>

        <div class="row">
            <div class="col-lg-6">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?=
                $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])
                ?>

                <div class="form-group">
                    <?= Html::submitButton('ارسال', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
			<div class="col-lg-6">
				<div>
				<h3>آدرس:</h3>
					<p>تهران , خیابان وحید دستگردی، خیایان فرید افشار، کوچه نور، پلاک 3 ،طبقه ی 5 , شرکت صباپال </p>
					<br>
					<h3>تلفن:</h3>
					<p>02122266555 </p>
					<br>
					<h3>ایمیل:</h3>
					<p>info@sabapal.ir</p>
				</div>
			</div>
        </div>

    </div>
</div>