<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
       'catalogos' => [
            'class' => 'app\modules\catalogos\Catalogos',
        ],
         'calendarios' => [
            'class' => 'app\modules\calendarios\calendarios',
        ],
        'clientes' => [
            'class' => 'app\modules\clientes\clientes',
        ],
        'contactos' => [
            'class' => 'app\modules\contactos\contactos',
        ],
        'cotizaciones' => [
            'class' => 'app\modules\cotizaciones\cotizaciones',
        ],
        'expertos' => [
            'class' => 'app\modules\expertos\expertos',
        ],
        'ensayos' => [
            'class' => 'app\modules\ensayos\ensayos',
        ],
        'usuarios' => [
            'class' => 'app\modules\usuarios\usuarios',
        ],
        'alertas' => [
            'class' => 'app\modules\alertas\alertas',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'markdown' => [
        'class' => 'kartik\markdown\Module',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sena_dev',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            //'host' => 'smtp.gmail.com',
            'host' => 'mail.sena.mx',
            'username' => 'sistemas@sena.mx',
            'password' => 'S2Q{uN~z(u6Y',
            //'port' => '587',
            'port' => '26',
            //'encryption' => 'ssl',
            'encryption' => 'tls',
        ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'formatter' => [
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'America/Monterrey',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat'=>'php:d-M-Y H:i:s'
        ],
        'db' => $db,
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

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
