<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InternalPay */

$this->title = 'ویرایش :  ' . $model->website_name;
$this->params['breadcrumbs'][] = ['label' => 'Internal Pays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="marginRL">
    <hr/>
    <div class="internal-pay-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
