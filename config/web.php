<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'language' => 'ru',
    'id' => 'basic',
    'name' => 'Simple Image Manager',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\ApiModule',
        ],
         'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '123',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
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
        'urlManager' => [
                'class' => 'yii\web\UrlManager',
                'enablePrettyUrl' => true,
                'enableStrictParsing' => true,
                'showScriptName' => false,
                'rules' => [
                    [
                        'class' => 'yii\rest\UrlRule',
                        'controller' => ['api/profiles' => 'api/profile', 
                        'api/users' => 'api/user', 
                        'api/orders' => 'api/order']
                    ],
                    [
                        'class' => 'yii\rest\UrlRule',
                        'controller' => ['api/' => 'api/default'],
                        'extraPatterns' => ['POST send-email' => 'send-email']
                    ],
                    [
                        'class' => 'yii\rest\UrlRule',
                        'controller' => ['api/' => 'api/default'],
                        'extraPatterns' => ['POST recover' => 'recover']
                    ],
                    [
                        'class' => 'yii\rest\UrlRule',
                        'controller' => ['api/' => 'api/default'],
                        'extraPatterns' => ['POST login' => 'login']
                    ],
                    [
                        'class' => 'yii\rest\UrlRule',
                        'controller' => ['api/' => 'api/default'],
                        'extraPatterns' => ['POST register' => 'register']
                    ], 
                    
                    'admin/' => 'admin/default',
                    'admin/users' => 'admin/user/index',
                    'admin/users/create' => 'admin/user/create',
                    'admin/users/view/<id:\d+>' => 'admin/user/view',
                    'admin/users/update/<id:\d+>' => 'admin/user/update',
                    'admin/users/delete/<id:\d+>' => 'admin/user/delete',
                    
                    'admin/profiles' => 'admin/profile/index',
                    'admin/profiles/create' => 'admin/profile/create',
                    'admin/profiles/view/<id:\d+>' => 'admin/profile/view',
                    'admin/profiles/update/<id:\d+>' => 'admin/profile/update',
                    'admin/profiles/delete/<id:\d+>' => 'admin/profile/delete',
                    
                    'admin/orders' => 'admin/order/index',
                    'admin/orders/create' => 'admin/order/create',
                    'admin/orders/view/<id:\d+>' => 'admin/order/view',
                    'admin/orders/update/<id:\d+>' => 'admin/order/update',
                    'admin/orders/delete/<id:\d+>' => 'admin/order/delete',
                         
            ]
          ],

        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
