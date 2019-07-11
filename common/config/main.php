<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'fa-IR',
    'sourceLanguage' => 'fa-IR',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ]
    ],
    'components' => [
	 'formatter' => [
        'class' => 'yii\i18n\formatter',
        'thousandSeparator' => ',',
        'decimalSeparator' => '.',
    ],
	  'data' => [
         
            'class' => 'common\components\Data',

            ],
	  'data2' => [
         
            'class' => 'common\components\Data2',

            ],
        'jdate' => [
            'class' => 'jDate\DateTime'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Hide index.php
            'showScriptName' => false,
            // Use pretty URLs
            'enablePrettyUrl' => true,
            'rules' => [
            ],
        ],
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=sabapal',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
