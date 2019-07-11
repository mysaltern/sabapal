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
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Colo Shop Template">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../../web/productSell/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/owl.carousel.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/owl.theme.default.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/animate.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/single_styles.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/single_responsive.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/contact_responsive.css" rel="stylesheet" type="text/css"/>
        <link href="../../web/productSell/css/mrh.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>

        <div class="super_container">

            <!-- Header -->

            <header class="header trans_300">

                <!-- Main Navigation -->

                <div class="main_nav_container">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <div class="logo_container">
                                    <a href="#"><span>صبا</span>پال</a>
                                </div>
                                <nav class="navbar">
                                    <ul class="navbar_menu">
                                        <?php
                                        $httpsAbsoluteHomeUrl = "https://www.sabapal.ir";
                                        ?>
                                        <li><a href="<?= $httpsAbsoluteHomeUrl ?>">خانه</a></li>

                                    </ul>
                                    <!--                                    <ul class="navbar_user">
                                                                            <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                                                                            <li class="checkout">
                                                                                <a href="#">
                                                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                                                    <span id="checkout_items" class="checkout_items">2</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>-->
                                    <div class="hamburger_container">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </header>

            <div class="fs_menu_overlay"></div>

            <!-- Hamburger Menu -->

            <div class="hamburger_menu">
                <div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
                <div class="hamburger_menu_content text-left">
                    <ul class="menu_top_nav">
                        <?php
                        $httpsAbsoluteHomeUrl = "https://www.sabapal.ir";
                        ?>
                        <li class="menu_item"><a href="<?= $httpsAbsoluteHomeUrl ?>">خانه</a></li>

                    </ul>
                </div>
            </div>









            <?php
            $txtStatus = Yii::$app->ReadHttpHeader->primary(Yii::$app->user->id);
            ?>



            <?= $content ?>












            <!-- Footer -->

            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
                                <ul class="footer_nav">
                                    <li><a href="#">صباپال</a></li>
                                    <li><a href="#">درباره ما</a></li>
                                    <li><a href="contact.html">ارتباط با ما</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--                        <div class="col-lg-6">
                                                    <div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
                                                        <ul>
                                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                                            <li><a href="#"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
                                                            <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>-->
                    </div>
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div class="footer_nav_container">
                                <div class="cr">کلیه ی حقوق این وبسایت متعلق به <a href="https://www.sabapal.ir/">صباپال</a> می باشد © 2018</div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

        <script src="../../web/productSell/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/popper.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/isotope.pkgd.min.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/owl.carousel.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/easing.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/jquery-ui.js" type="text/javascript"></script>
        <script src="../../web/productSell/js/single_custom.js" type="text/javascript"></script>

    </body>

</html>
<?php $this->endPage() ?>