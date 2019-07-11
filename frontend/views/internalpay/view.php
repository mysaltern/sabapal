<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InternalPay */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Internal Pays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="internal-pay-view">

        <!--<h1><?php // echo Html::encode($this->title)   ?></h1>-->

        <p>
            <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('حذف', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
//                'userID',
                'website_name',
                'website_url:url',
                'customer_tell',
                'website_desc',
                'website_categoryID',
                'ip',
//                'active',
//                'deleted',
//                'date',
                'private_code',
            ],
        ])
        ?>

    </div>
	
	
</div>
