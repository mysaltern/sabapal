<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserConfirmatory */
?>
<div class="user-confirmatory-create">
<?=
$this->render('_form', [
    'model' => $model,
    'ticket' => $ticket,
])
?>
</div>
