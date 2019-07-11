<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserConfirmatory */

$this->title = 'ارسال مدارک ';
$this->params['breadcrumbs'][] = ['label' => 'تایید هوییت', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-confirmatory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
