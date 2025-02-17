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
use Gm\Panel\Data\Provider\Pagination;
use Gm\Exception\InvalidArgumentException;

/**
 * Готовые решения каталога Маркетплейс.
 * 
 * Делает запрос к API серверу для получения компонентов Маркетплейс.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Marketplace\ApiCommand
 * @since 1.0
 */
class Components extends Base
{
    /**
     * Пагинация или параметры конфигурации пагинации элементов данных.
     * 
     * Если указаны параметры, то будет создан объект пагинации в {@see BaseProvider::configure()}.
     * Если значение `false`, разбивка элементов на страницы будет не доступна.
     * 
     * @see BaseProvider:setPage()
     *
     * @var Pagination|array|false|null
     */
    public Pagination|array|false|null $pagination = null;

    /**
     * {@inheritdoc}
     */
    public function configure(array $config): void
    {
        parent::configure($config);

        if (is_array($this->pagination)) {
            $this->setPagination($this->pagination);
        }
    }

    /**
     * Устанавливает или создаёт объект пагинации (разбивки элементов на страницы).
     * 
     * @see BaseProvider::$pagination
     * 
     * @param Pagination|array|false $value Объект пагинации или параметры конфигурации для 
     *     создания объекта. Если значение `false`, пагинация будет не доступна.
     * 
     * @return void
     * 
     * @throws InvalidArgumentException Неправильно указано значение пагинации.
     */
    public function setPagination(Pagination|array|false $value): void
    {
        if (is_array($value)) {
            if (isset($value['class']))
                $this->pagination = Gm::createObject($value);
            else
                $this->pagination = new Pagination($value);
        } else
        if ($value instanceof Pagination || $value === false)
            $this->pagination = $value;
        else
            // Для установки нумерация страниц, необходимо чтобы значение имело массив 
            // параметров конфигурации или значение `false`
            throw new InvalidArgumentException(
                'To set pagination, it is necessary that the value has an array of configuration parameters or false.'
            );
    }

    /**
     * Возвращает объект пагинации (разбивки элементов на страницы), используемый 
     * поставщиком данных.
     * 
     * @see BaseProvider::$pagination
     * 
     * @return Pagination|false Возвращает значение `false`, если пагинация не доступна.
     */
    public function getPagination(): Pagination|false
    {
        if ($this->pagination === null) {
            $this->setPagination([]);
        }
        return $this->pagination;
    }

    /**
     * Возвращает элементы панели.
     * 
     * @return array|false 
     */
    public function findItems(array $filter = []): array|false 
    {
        $params = $this->getPagination()->getQueryParams();
        $params['licenseKey'] = $this->getLicenseKey();

        /** @var array|bool $response */
        $response = $this->execute(
            '/components', ['post' => $params]
        );
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
}
