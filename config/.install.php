<?php
/**
 * Этот файл является частью модуля веб-приложения GearMagic.
 * 
 * Файл конфигурации установки модуля.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    'use'         => BACKEND,
    'id'          => 'gm.be.mp',
    'name'        => 'Marketplace',
    'description' => 'Installing ready-made modules and extensions',
    'expandable'  => true,
    'namespace'   => 'Gm\Backend\Marketplace',
    'path'        => '/gm/gm.be.mp',
    'route'       => 'marketplace',
    'routes'      => [
        [
            'type'    => 'extensions',
            'options' => [
                'module'      => 'gm.be.mp',
                'route'       => 'marketplace[/:extension[/:controller[/:action[/:id]]]]',
                'prefix'      => BACKEND,
                'constraints' => [
                    'id' => '[0-9_-]+'
                ],
                'redirect' => [
                    'info:*@*' => ['info', '*', null]
                ]
            ]
        ]
    ],
    'locales'     => ['ru_RU', 'en_GB'],
    'permissions' => ['any', 'extension', 'info'],
    'events'      => [],
    'required'    => [
        ['php', 'version' => '8.2'],
        ['app', 'code' => 'GM MS'],
        ['app', 'code' => 'GM CMS'],
        ['app', 'code' => 'GM CRM'],
        ['module', 'id' => 'gm.be.mp']
    ]
];
