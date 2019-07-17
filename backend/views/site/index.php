<?php
/* @var $this yii\web\View */

use common\models\User;
use common\models\Wage;
use common\models\Profit;
use yii\web\View;


$this->title = 'SabaPal (admin)';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>خوش آمدید</h1>


        <?php
        $userData = User::getUsers();
        $profits = Profit::getProfit();
        $profit = $profits['percent'];

        foreach ($userData as $user_id) {


            $userid = $user_id['id'];
            $a = Profit::Profit($userid, $profit);

            echo '<br>' . $a;


        } ?>


    </div>


</div>
