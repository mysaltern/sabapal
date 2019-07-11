<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'language' => 'fa-IR',
    'sourceLanguage' => 'fa-IR',
    'timezone' => 'Asia/Tehran',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'controllerMap' => [
                'admin' => 'frontend\controllers\user\AdminController',
                'profile' => 'frontend\controllers\user\ProfileController',
                'recovery' => 'frontend\controllers\user\RecoveryController',
                'registration' => 'frontend\controllers\user\RegistrationController',
                'security' => 'frontend\controllers\user\SecurityController',
                'settings' => 'frontend\controllers\user\SettingsController',
            ],
            'admins' => ['admin']
        ],
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
               'host' => 'mail.sabapal.ir',
     //          'host' => '127.0.0.1',
//                'username' => 'support@ecomiran.com',
                'username' => 'info@sabapal.ir',
                'password' => '12345678',
//                'password' => 'sup900!',
               'port' => '25',
                // 'encryption' => 'tls',
            ],
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
//            'useFileTransport' => true,
        ],
        //'formatter' => ['locale' => 'fa_IR@calendar=persian', 'calendar' => \IntlDateFormatter::TRADITIONAL,],
//        'modules' => [
//        'user' => [
//            'class' => 'dektrium\user\Module',
//            'identityClass' => 'dektrium\user\Module',
//        ],
//        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'scriptUrl' => '/sabapal/frontend/web/index.php',
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                    [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'PaymentRequest' => [
            'class' => 'mongosoft\soapclient\Client',
            'url' => 'http://myservice.com/api/hello',
            'options' => [
                'cache_wsdl' => WSDL_CACHE_NONE,
            ],
        ],
        'PaymentVerification' => [
            'class' => 'mongosoft\soapclient\Client',
            'url' => 'http://myservice.com/api/hello',
            'options' => [
                'cache_wsdl' => WSDL_CACHE_NONE,
            ],
        ],
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'params' => $params,
];
