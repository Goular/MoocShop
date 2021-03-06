<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index',//设置默认的控制器
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'K3ElY1vw-6iofz12XUJbm1UZnwxpkZ8z',
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
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.126.com',
                'username' => 'zhaojt_wechat@126.com',
                'password' => 'zhao307161',
                'port' => '465',
                'encryption' => 'ssl',
            ]
            //password不是网易邮箱密码，而是网易邮箱的客户端授权密码，请注意，但是我们自建邮件服务器不会出现这样的问题
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
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
            'enablePrettyUrl' => true,  //美化url==ture
            'enableStrictParsing' => false,  //不启用严格解析
            'showScriptName' => false,   //隐藏index.php
            'rules' => [
                "<module:[-\w]+>/<controller:[-\w]+>/<action:[-\w]+>/<id:\d+>" => "<module>/<controller>/<action>",
                "<controller:[-\w]+>/<action:[-\w]+>/<id:\d+>" => "<controller>/<action>",
                "<controller:[-\w]+>/<action:[-\w]+>" => "<controller>/<action>"
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => 'faf6c707f0b1f1dc9823',
                    'clientSecret' => 'd959cb1123b950885d394db6f111bda38d2a7877',
                ],

            ],
        ],
        'memcache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '192.168.148.156',
                    'port' => 11211,
                    'weight' => 40,
                ],
                [
                    'host' => '192.168.148.156',
                    'port' => 11212,
                    'weight' => 30,
                ],
                [
                    'host' => '192.168.148.156',
                    'port' => 11213,
                    'weight' => 30,
                ]
            ],
        ],
        'session' => [
            'class' => 'yii\web\CacheSession',
            'cache' => 'memcache',
        ]
    ],
    'params' => $params,
    //配置模块的使用
    "modules" => [
        'admin' => ['class' => 'app\admin\modules'],//这个admin的文件目录和名字创建时慕课教我的，感觉不太对
        'mobile' => ['class' => 'app\mobile\modules']//根据文档写的类名比较合适，而且命名空间就是app\mobile\controller,是合适的
    ]
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
