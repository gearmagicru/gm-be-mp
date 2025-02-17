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

/**
 * Готовые решения каталога Маркетплейс.
 * 
 * Делает запрос к API серверу для получения компонентов Маркетплейс.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Marketplace\ApiCommand
 * @since 1.0
 */
class ApiCommand extends Base
{
    /**
     * Возвращает информацию о компоненте Маркетплейс.
     * 
     * @return array|false Возвращает значение `false`, если невозможно выполнить 
     *     запрос к API серверу.
     */
    public function getComponent(string $id): array|false
    {
        /** @var array|bool $response */
        $response = $this->execute('/component', [
            'post' => ['id' => $id]
        ]);

        // ошибка выполнения запроса
        if ($response === false || !$response['success']) {
            return false;
        }
        return $response['data'] ?? [];
    }

    /**
     * Возвращает каталог компонентов Маркетплейс.
     * 
     * @param array $params Параметры запроса.
     * 
     * @return array|false Возвращает значение `false`, если невозможно выполнить 
     *     запрос к API серверу.
     */
    public function getComponents(array $params = []): array|false
    {
        /** @var array|bool $response */
        $response = $this->execute('/components', [
            'post' => $params
        ]);

        // ошибка выполнения запроса
        if ($response === false || !$response['success']) {
            return false;
        }
        if (is_array($response['data']))
            return [
                'items' => $response['data']['items'] ?? [],
                'total' => $response['data']['total'] ?? 0
            ];
        else
            return ['items' => [], 'total' => 0];
    }

    /**
     * Возвращает термины Маркетплейс.
     * 
     * @return array|false Возвращает значение `false`, если невозможно выполнить 
     *     запрос к API серверу.
     */
    public function getTerms(): array|false
    {
        /** @var array|bool $response */
        $response = $this->execute('/terms');

        // ошибка выполнения запроса
        if ($response === false || !$response['success']) {
            return false;
        }
        return $response['data'] ?? [];
    }

    /**
     * Возвращает элементы панели.
     * 
     * @param string $componentDir Директория компонента Маркетплейс.
     * 
     * @return bool 
     */
    public function getDownload($downloadHandle, string $id): bool
    {
        /** @var bool $response */
        $response = $this->download(
            $downloadHandle,
            '/download', [
                'post' => ['id' => $id]
            ]
        );
        return $response;
    }
}
