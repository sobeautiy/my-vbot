<?php

$path = __DIR__.'/./../tmp/';

return [
    'path'     => $path,
    /*
     * swoole 配置项（执行主动发消息命令必须要开启）
     */
    'swoole'  => [
        'status' => false,
        'ip'     => '127.0.0.1',
        'port'   => '8866',
    ],
    /*
     * 下载配置项
     */
    'download' => [
        'image'         => false,
        'voice'         => false,
        'video'         => false,
        'emoticon'      => true,
        'file'          => false,
        'emoticon_path' => $path.'emoticons',
    ],
    /*
     * 输出配置项
     */
    'console' => [
        'output'  => true, // 是否输出
        'message' => true, // 是否输出接收消息 （若上面为 false 此处无效）
    ],
    /*
     * 日志配置项
     */
    'log'      => [
        'level'         => 'debug',
        'permission'    => 0777,
        'system'        => $path.'log',
        'message'       => $path.'log',
    ],
    /*
     * 缓存配置项
     */
    'cache' => [
        'default' => 'redis',
        'stores'  => [
            'file' => [
                'driver' => 'file',
                'path'   => $path.'cache',
            ],
            'redis' => [
                'driver'     => 'redis',
                'connection' => 'default',
            ],
        ],
    ],
    'database' => [
        'redis' => [
            'client'  => 'predis',
            'default' => [
                'host'     => '127.0.0.1',
                'password' => null,
                'port'     => 6379,
                'database' => 13,
            ],
        ],
    ],
    /*
     * 拓展配置
     * ==============================
     * 如果加载拓展则必须加载此配置项
     */
    'extension' => [
        // 管理员配置（必选），优先加载 remark_name
        'admin' => [
            'remark'   => '',
            'nickname' => 'HanSon',
        ],
        'blacklist' => [
            'type' => [
                'text', 'emoticon'
            ],
            'warn' => function ($message) {
                $nickname = $message['fromType'] == 'Group' ? $message['sender']['NickName'] : $message['from']['NickName'];
                \Hanson\Vbot\Message\Text::send($message['from']['UserName'], "@{$nickname} 警告！你的消息频率略高！");
            },
            'block' => function ($message) {
                $nickname = $message['fromType'] == 'Group' ? $message['sender']['NickName'] : $message['from']['NickName'];
                \Hanson\Vbot\Message\Text::send($message['from']['UserName'], "@{$nickname} 你已被永久拉黑！");
            },
        ]
    ],
];
