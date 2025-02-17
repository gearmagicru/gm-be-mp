<?php
/**
 * Этот файл является частью модуля веб-приложения GearMagic.
 * 
 * Файл конфигурации модуля.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */
return [
    'translator' => [
        'locale'   => 'auto',
        'patterns' => [
            'text' => [
                'basePath' => __DIR__ . '/../lang',
                'pattern'   => 'text-%s.php'
            ]
        ],
        'autoload' => ['text'],
        'external' => [BACKEND, 'api']
    ],

    'accessRules' => [
        // для авторизованных пользователей Панели управления
        [ // разрешение "Полный доступ" (any: extension)
            'allow',
            'permission' => 'any',
            'users'      => ['@backend']
        ],
        [ // разрешение "Расширение" (extension)
            'allow',
            'permission' => 'extension',
            'users'      => ['@backend']
        ],
        [ // разрешение "Информация о модуле" (info)
            'allow',
            'controllers' => ['Info'],
            'permission'  => 'info',
            'users'       => ['@backend']
        ],
        [ // для всех остальных, доступа нет
            'deny'
        ]
    ],

    'viewManager' => [
        'id'          => 'gm-marketplace-{name}',
        'useTheme'    => true,
        'useLocalize' => true,
        'viewMap'     => [
            // информации о модуле
            'info' => [
                'viewFile'      => '//backend/module-info.phtml', 
                'forceLocalize' => true
            ],
        ]
    ]
];
