<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
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
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'ادمین',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                    ['label' => 'خانه', 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest)
            {
                $menuItems[] = ['label' => 'ورود', 'url' => ['/user/security/login']];
            }
            else
            {

                $menuItems[] = ['label' => 'تیکت ها', 'url' => ['/ticket/index']];
                $menuItems[] = ['label' => 'تایید مدارک', 'url' => ['/confirmatory/index']];
                $menuItems[] = ['label' => 'درگاه ها ی داخلی', 'url' => ['/internalpay/index']];
                $menuItems[] = ['label' => 'درخواست تسویه', 'url' => ['/settlement/index']];
                $menuItems[] = ['label' => 'تراکنش ها', 'url' => ['/transaction/index']];
                $menuItems[] = ['label' => 'کاربران', 'url' => ['/user/admin']];
                $menuItems[] = ['label' => 'کارمزد', 'url' => ['/wage/index']];
                $menuItems[] = ['label' => 'نوع کارمزد', 'url' => ['/wagedetail/index']];
                $menuItems[] = ['label' => 'تعیین سود', 'url' => ['/profit/index']];
                $menuItems[] = '<li>'
                        . Html::beginForm(['/user/security/logout'], 'post')
                        . Html::submitButton(
                                'خروج (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>';
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <!--<p class="pull-left">&copy; Saba portal <?= date('Y') ?></p>-->

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
