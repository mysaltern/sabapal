<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

date_default_timezone_set("Asia/Tehran");
AppAsset::register($this);
$img = Yii::$app->params['image'];
?>
<?php $this->beginPage() ?>


<?php ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap core CSS -->

        <link href="../css/boot4RTL.css" rel="stylesheet" type="text/css"/>

        <link href="../../../../../css/animate.css" rel="stylesheet" type="text/css"/>
        <link href="../../../../../css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="../../../../../css/owl.carousel.css" rel="stylesheet" type="text/css"/>
        <link href="../../../../../css/owl.theme.default.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template -->
        <link href="../../../../../css/mrh.css" rel="stylesheet">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bcolorP4 fixed-top">
            <div class="container brand-rtl">
                <?php
                            $httpsAbsoluteHomeUrl = "https://www.sabapal.ir";
                            ?>
                <a class="navbar-brand" href="<?= $httpsAbsoluteHomeUrl ?>">
                    <img class="image-logo" src="../../../../../images/logo.png" alt=""/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav mr-auto">
                        <!--                        <li class="nav-item active">
                                                    <a class="nav-link" href="#">اپلیکیشن
                                                        <span class="sr-only">(current)</span>
                                                    </a>
                                                </li>-->
                        <li class="nav-item active">
                            <?php
                            $httpsAbsoluteHomeUrl = "https://www.sabapal.ir";
                            ?>
                            <a class="nav-link" href="<?= $httpsAbsoluteHomeUrl ?>">خانه
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <?php
                            $login = URL::to(['user/login']);
                            ?>
                            <a class="nav-link" href="<?= $login ?>">ورود
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">

                            <?php
                            $tariffs = URL::to(['page/tariffs']);
                            ?>
                            <a class="nav-link" href="<?= $tariffs ?>">تعرفه ها</a>
                        </li>
                        
                        <?php
                        $lab = URL::to(['lab/index']);
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $lab ?>">آزمایشگاه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.sabapal.ir/sabapal/frontend/web/site/contact">تماس با ما</a>
                        </li>
						 <li class="nav-item">
                            <a class="nav-link" href="https://www.sabapal.ir/sabapal/frontend/web/site/about">درباره ما</a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </nav>



        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->
        <?php
        $txtStatus = Yii::$app->ReadHttpHeader->primary(Yii::$app->user->id);
        ?>



        <?= $content
        ?>

        <!-- Footer -->
        <footer class="py-5 bcolorP4 footer-typo">

            <div class="container">
                <div class="row">
                    <!--                    <div class="col-lg-3 col-md-6 col-sm-12">
                                            <h2>خدمات</h2>
                                            <hr>
                                            <a href="#">
                                                <p>
                                                    اپلیکیشن صبا پال
                                                </p>
                                            </a>
                                            <a href="#">
                                                <p>
                                                    درگاه پرداخت اینترنت صبا پال
                                                </p>

                                            </a>
                                            <a href="#">
                                                <p>
                                                    خدمات شارژ
                                                </p>

                                            </a>
                                            <a href="#">
                                                <p>
                                                    خدمات پرداخت
                                                </p>

                                            </a>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <h2>لینک های مرتبط</h2>
                                            <hr>
                                            <a href="#">
                                                <p>
                                                    قوانین و مقررات
                                                </p>

                                            </a>
                                            <a href="#">
                                                <p>
                                                    حریم خصوصی
                                                </p>

                                            </a>
                                            <a href="#">
                                                <p>
                                                    درباره ما
                                                </p>

                                            </a>
                                        </div>-->

                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <h2>تماس با ما</h2>
                        <hr>
                        <a href="#">
                            <p>
                                تهران  , خیابان وحید دستگردی، خیایان فرید افشار، کوچه نور، پلاک 3 ،طبقه ی 5     ,  شرکت صباپال
                            </p>
                        </a>
                        <a href="#">

                            <p>
                                تلفن: 02122266555
                            </p>
                        </a>
                        <a href="#">

                            <p>
                                ایمیل: info@sabapal.ir
                            </p>
                        </a>
                        <a href="#"></a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        
                        <a href="#">
                            <img class="img-fluid namad" src="../../../../../images/enamad.png" alt="enamad"/>
                        </a>
                        <a href="#">
                            <img class="img-fluid namad" src="../../../../../images/eanjoman.png" alt="eanjoman"/>
                        </a>
                        <a href="#"></a>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
            <div class="container">
                <p class="m-0 text-center text-white">کلیه ی حقوق این وبسایت متعلق به <a href="#">صباپال</a> می باشد &copy; 2018</p>
            </div>
            <!-- /.container -->
        </footer>



        <?php $this->endBody() ?>
        <script type="text/javascript">
            $(document).ready(function () {

                demo.initChartist();

                //                $.notify({
                //                    icon: 'pe-7s-gift',
                //                    message: "Welcome to <b> Sabapal Dashboard</b> - a beautiful freebie for every web developer."
                //
                //                }, {
                //                    type: 'info',
                //                    timer: 4000
                //                });

            });
        </script>
    </body>
</html>
<?php $this->endPage() ?>
