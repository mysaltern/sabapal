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
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <!--        <div class="container-fluid">
                <img class="imgHead img-responsive" src="<?php // echo $img;                                      ?>/head.jpg" alt=""/>
                    <div class="backcolor">

                        <i class="row1">
                            صبا پال :
                        </i>
                        <i class="row2">
                            در گاه واسط پرداخت
                        </i>
                    </div>
                </div>-->
        <div class="wrapper" >
            <div class="sidebar"  data-color="purple" data-image="<?php echo $img; ?>/head.jpg">

                <!--

                    Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
                    Tip 2: you can also add an image using data-image tag

                -->
                <?php
                $txtStatus = Yii::$app->ReadHttpHeader->primary(Yii::$app->user->id);
                ?>
                <div class="sidebar-wrapper"  style="background-color: #2f5571;">
                    <div class="logo" style="background-color: #2f5571;">
                        <a href=" " class="simple-text">
                            صبا پال
                        </a>
                        <span class="primaryTXT">
                            <?php echo '   (' . $txtStatus . ')   '; ?>
                        </span>
                    </div>
                    <?php
                    $homeURL = Url::to(['/site/index']);
                    ?>
                    <ul class="nav"  >
                        <?php
                        if (!Yii::$app->user->isGuest)
                        {
                            ?>



                            <!--                            <li class="active">
                                                            <a href="<?php echo $homeURL; ?>">
                                                                <i class="pe-7s-graph"></i>
                                                                <p>داشبورد</p>
                                                            </a>
                                                        </li>-->
                            <?php
                        }
                        $internalpay = Url::to(['/internalpay/index']);
                        ?>
                        <li>
                            <a href="<?php echo $internalpay; ?>">
                                <i class="pe-7s-bell scrollup"></i>
                                <p>درگاه های پرداخت</p>
                            </a>
                        </li>
                        <!--                        <li>
                                                    <a href="table.html">
                                                        <i class="pe-7s-note2"></i>
                                                        <p>آسان پرداخت</p>
                                                    </a>
                                                </li>-->

                        <?php
                        $internalpay = Url::to(['/internalpay/index']);
                        ?>
                        <?php
                        $bankaccounts = Url::to(['/bankaccounts/index']);
                        ?>
                        <li>
                            <a  href="<?php echo $bankaccounts; ?>">
                                <i class="pe-7s-cash scrollup"></i>
                                <p>حساب بانکی  </p>
                            </a>
                        </li>
                        <li>
                            <?php
                            $transaction = Url::to(['/transaction/index']);
                            ?>
                            <a href="<?php echo $transaction; ?>">
                                <i class="pe-7s-science scrollup"></i>
                                <p>امور مالی</p>
                            </a>
                        </li>


                        <?php
                        $ticket = Url::to(['/ticket/index']);
                        ?>
                        <li>
                            <a href="<?php echo $ticket; ?>">
                                <i class="pe-7s-map-marker scrollup"></i>
                                <p>تیکت ها</p>
                            </a>
                        </li>
                        <?php
                        $con = Url::to(['/user/settings/account']);
                        ?>

                        <li>
                            <a href="<?php echo $con; ?>">
                                <i class="pe-7s-user scrollup"></i>
                                <p>مشخصات کاربری   </p>
                            </a>
                        </li>

                    </ul>
					 <footer class="footer">
                        <div class="container-fluid footer-links">
                            <div class="row footer-links-top">
                                <nav class="hidden-sm hidden-xs">

                                    <div class="col-lg-6 footer-link">
                                        <a  href="<?php echo $transaction; ?>">
                                            امور مالی
                                        </a>
                                    </div>
                                    <div class="col-lg-6 footer-link">
                                        <a href="<?php echo $con; ?>">
                                            مشخصات کاربری
                                        </a>
                                    </div>
                                    <div class="col-lg-6 footer-link">
                                        <a href="<?php echo $ticket; ?>">
                                            تیکت
                                        </a>
                                    </div>
                                    <div class="col-lg-6 footer-link">
                                        <a href="<?php echo $bankaccounts; ?>">
                                            حساب های بانکی
                                        </a>
                                    </div>

                                </nav>
                            </div>

                            <p class="copyright text-center hidden-sm hidden-xs">
                                &copy; 2019 <a href="http://www.sabapal.ir"> SabaPal</a>
                            </p>


                        </div>
                    </footer>
                </div>
            </div>

            <div class="main-panel">
                <nav class="navbar navbar-default navbar-fixed">
                    <div class="container-fluid">
                        <?php
                        $homeURL = Url::to(['/site/index']);
                        ?>
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!--<a class="navbar-brand" href="<?php // echo $homeURL;                            ?>">داشبورد</a>-->
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-left">
                                <!--                                <li>
                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                        <i class="fa fa-dashboard"></i>
                                                                    </a>
                                                                </li>-->
                                <!--                                <li class="dropdown">
                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                        <i class="fa fa-globe"></i>
                                                                        <b class="caret"></b>
                                                                        <span class="notification">5</span>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="#">Notification 1</a></li>
                                                                        <li><a href="#">Notification 2</a></li>
                                                                        <li><a href="#">Notification 3</a></li>
                                                                        <li><a href="#">Notification 4</a></li>
                                                                        <li><a href="#">Another notification</a></li>
                                                                    </ul>
                                                                </li>-->
                                <!--                                <li>
                                                                    <a href="">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>
                                                                </li>-->
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <?php
                                    $userURL ='https://sabapal.ir/sabapal/frontend/web/transaction/index';
                                    ?>
                                    <a href = "<?php echo $userURL; ?>">
                                        خانه
                                    </a>
                                </li>

                                    <?php ?>
                                    <li>
                                    <?php
                                    if (!isset(Yii::$app->user->id))
                                    {
                                        $userURL = Url::to(['/user/register']);
                                        ?>
                                        <a href = "<?php echo $userURL; ?>">
                                            ثبت نام
                                        </a>
                                    </li>

                                    <?php
                                }
                                ?>
                                <li>
                                    <?php
                                    if (isset(Yii::$app->user->id))
                                    {
                                        $enter = Url::to(['/user/logout']);
                                        $txt = 'خروج';
                                    }
                                    else
                                    {
                                        $enter = Url::to(['/user/login']);
                                        $txt = 'ورود';
                                    }
                                    ?>
                                    <a href = "<?php echo $enter; ?>">
                                <?php echo $txt; ?>
                                    </a>
                                </li>
<?php
if (isset(Yii::$app->user->id))
{
    ?>

                                    <li class = "dropdown">
                                        <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
                                            امکانات
                                            <b class = "caret"></b>
                                        </a>
                                        <ul class = "dropdown-menu">
                                            <?php
                                            $contact = Url::to(['/contact/create']);
                                            ?>
                                            <li><a href = "<?php echo $contact; ?>">اطلاعات کاربری</a></li>
                                            <?php
                                            $doc = Url::to(['/document/file']);
                                            if (!\Yii::$app->user->can('document'))
                                            {
                                                ?>
                                                <li><a href = "<?php echo $doc; ?>">آپلود مدارک</a></li>

                                                <?php
                                            }
                                            ?>
                                            <?php
                                            $ticket = Url::to(['/ticket/index']);
                                            ?>
                                            <li><a href = "<?php echo $ticket; ?>">تیکت</a></li>
    <?php
    $profile = Url::to(['/user/settings/account']);
    ?>
                                            <li><a href = "<?php echo $profile; ?>">مشخصات کاربری</a></li>
    <?php
    $bankaccounts = Url::to(['/bankaccounts/index']);
    ?>
                                            <li><a href = "<?php echo $bankaccounts; ?>">حساب های بانکی</a></li>
                                            <!--                                            <li><a href = "#">Another action</a></li>
                                                                                        <li><a href = "#">Something</a></li>
                                                                                        <li class = "divider"></li>
                                                                                        <li><a href = "#">Separated link</a></li>-->
                                        </ul>
                                    </li>
                    <?php
                }
                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
<?= $content
?>


            </div>
        </div>

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
