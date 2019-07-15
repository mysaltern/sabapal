<?php


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Wagedetail */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="wagedetail-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $wageName = ArrayHelper::map(\common\models\Wage::find()->orderBy('name')->all(), 'id', 'name') ?>
    <?= $form->field($model, 'wage_id')->dropDownList($wageName, ['prompt' => '---- Select Wage ----'])->label('Wage Name') ?>

    <?= $form->field($model, 'fixpercent')->textInput() ?>

    <?= $form->field($model, 'varpercent')->textInput() ?>

    <?= $form->field($model, 'date')->dropDownList(['prompt' => '---- Select Days of Week ----', '0' => 'شنبه', '1' => 'یکشنبه', '2' => 'دوشنبه', '3' => 'سه شنبه', '4' => 'چهارشنبه', '5' => '5شنبه', '6' => 'جمعه']) ?>

    <?= $form->field($model, 'startprice')->textInput() ?>

    <?= $form->field($model, 'endprice')->textInput() ?>


    <?php if (!Yii::$app->request->isAjax)
        {

        ?>
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

<?php ActiveForm::end(); ?>

</div>
