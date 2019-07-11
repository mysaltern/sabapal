<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
    {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/bootstrap.min.css',
        'css/bootstrap-rtl.css',
        'css/animate.min.css',
        'css/light-bootstrap-dashboard.css',
        'css/light-bootstrap-dashboard-rtl.css',
        'css/demo.css',
        'css/rtl.css',
//        'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
        'http://fonts.googleapis.com/css?family=Roboto:400,700,300',
        'css/pe-icon-7-stroke.css',
        'fonts/font.css',
        'css/saltern.css',
    ];
    public $js = [
//        'js/jquery-1.10.2.js',
        'js/bootstrap.min.js',
        'js/bootstrap-checkbox-radio-switch.js',
        'js/chartist.min.js',
        'js/bootstrap-notify.js',
        'https://maps.googleapis.com/maps/api/js?sensor=false',
        'js/light-bootstrap-dashboard.js',
        'js/demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];

    }
