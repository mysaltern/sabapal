<?php

use yii\helpers\Html;
use yii\helpers\URL;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */

$this->title = 'انتخاب نحوه پرداخت';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marginRL">
    <hr/>
    <div class="transaction-create">

        <h3 class="text-center"><?= Html::encode($this->title) ?></h3>

        <div class="container">
    <div class="row">
        <div class="col-lg-6 col-sm-12 paymentMethodCard">
			<label>
			<?php
			 $token = $_GET['Token'];
			$url = Url::to(['api/render', 'Token' => $token,'method'=>'Online']);
		 
			
			?>
			<a href="<?= $url ?>">
			<input type="radio" class="form-check-input card-input-element" id="onlinepay" name="materialExampleRadios">
			<div class="p-3 row text-center card-input">
			
			<div class="col-lg-6 col-xs-6">
			
				<p class="p-2 form-check-label" for="onlinepay">پرداخت آنلاین</p>
			
			</div>
			
			<div class="col-lg-6 col-xs-6">
				<i class="fa fa-credit-card-alt fa-3x" aria-hidden="true"></i>
			</div>
			</div>
			</a>
			</label>
        </div>
        <div class="col-lg-6 col-sm-12 paymentMethodCard">
            <label>
			<input type="radio" class="form-check-input card-input-element" id="packetpay" name="materialExampleRadios">
			<div class="p-3 text-center card-input">
				<div class="row">
					<div class="col-lg-6 col-xs-6">
					<form method="post" action="">
					<input class="p-2 form-check-label packetpay" for="packetpay" type="submit" value="پرداخت از طریق کیف پول">
					
					<input type="hidden"  name="method" value="online">
					</div>
					
					
					
					</form>
					<div class="col-lg-6 col-xs-6">
						<i class="fa fa-get-pocket fa-3x" aria-hidden="true"></i>
					</div>
				</div>
				<div id="sublogin" class="p-3">
					<div class="row">
				
						<form action="" autocomplete="off" class="p-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="نام کاربری" name="username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="کلمه عبور" name="password">
                            </div>
                            <button type="button" id="sendlogin" class="btn btn-success">ورود</button>
                        </form>
					</div>
				</div>
            </div>
			</label>
			<?php
			
			
			 if(isset(Yii::$app->user->id))
				 {
					 
					 ?>
			<div class="pocketAmount text-center row">
				<div class="p-3 col-lg-6">
				<p>
				 موجودی کیف پول
				</p>
				</div>
				<div class="p-3 col-lg-6">
				<p>
				 <?php
				
					 $money = Yii::$app->ReadHttpHeader->money(Yii::$app->user->id);
				      echo $money; 
				 
				      
				 ?>
				</p>
				</div>
			</div>
			
			<?php
			
			
			}
			?>
        </div>
    </div>
</div>


    </div>
</div>
