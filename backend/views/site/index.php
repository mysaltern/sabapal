<?php

/* @var $this yii\web\View */


use common\models\User;
use common\models\Wage;
use common\models\Profit;
use yii\web\View;


$this->title = 'SabaPal (admin)';

?>

<head>

    <title>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</title>

    <script src="../web/js/jquery.min"></script>

    <script src="../web/js/instascan.min.js"></script>

</head>
<body>
    <div class="site-index">

        <div class="jumbotron">
            <h1>خوش آمدید</h1>


            <?php

            $userData = User::getUsers();
            $profits = Profit::getProfit();
            $profit = $profits['percent'];

            foreach ($userData as $user_id)
            {


                $userid = $user_id['id'];
                $a = Profit::Profit($userid, $profit);

                echo '<br>' . $a;
            }

            ?>


        </div>


    </div>


    <button onclick="qrScaner()" >QR SCAN</button>

    <input id="add">


    <video id="preview"></video>


    <script type="text/javascript">
        function qrScaner() {
            let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

            scanner.addListener('scan', function (content) {

                document.getElementById('add').value = content;

            });

            Instascan.Camera.getCameras().then(function (cameras) {

                if (cameras.length > 0) {

                    scanner.start(cameras[0]);

                } else {

                    console.error('No cameras found.');

                }

            }).catch(function (e) {

                console.error(e);

            });
        }
        ;


    </script>
</body>