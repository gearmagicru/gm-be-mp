<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

 namespace Gm\Backend\Marketplace\ApiCommand;

use Gm;
use Gm\Api\ServerCommand;

/**
 * Базовый класс запросов от каталога Маркетплейс к API серверу.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Marketplace\ApiCommand
 * @since 1.0
 */
class Base extends ServerCommand
{
    /**
     * {@inheritdoc}
     */
    public function getUrl(): ?string
    {
        return Gm::$app->config->apiMarketplaceServer['url'];
    }
}
