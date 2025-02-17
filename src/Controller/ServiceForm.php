<?php
/**
 * Этот файл является частью модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Backend\Marketplace\Controller;

use Gm;
use Gm\Panel\Http\Response;
use Gm\Mvc\Module\BaseModule;
use Gm\Panel\Widget\EditWindow;
use Gm\Panel\Controller\FormController;

/**
 * Контроллер формы конфигурации службы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Marketplace\Controller
 * @since 1.0
 */
class ServiceForm extends FormController
{
    /**
     * {@inheritdoc}
     * 
     * @var BaseModule|\Gm\Backend\Marketplace\Module 
     */
    public BaseModule $module;

    /**
     * {@inheritdoc}
     */
    public function createWidget(): EditWindow
    {
        /** @var EditWindow $window */
        $window = parent::createWidget();

        // окно компонента (Ext.window.Window Sencha ExtJS)
        $window->xtype = 'g-window';
        $window->id = $this->module->viewId('window');
        $window->cls = 'g-window_profile';
        $window->title = sprintf(
            '%s <span>%s</span>', $this->module->t('{name}'), $this->module->t('{description}')
        );
        $window->titleTpl = $window->title;
        $window->icon = $this->module->getIconUrl();
        $window->layout = 'fit';
        $window->ui = 'install';
        $window->resizable = false;

        // панель формы (Gm.view.form.Panel GmJS)
        $window->form->bodyPadding = 5;
        $window->form->id = $this->module->viewId('form');
        $window->form->router = [
            'route' => $this->module->route('/form'),
            'state' => $window->form::STATE_UPDATE,
            'rules' => [
                'submit' => '{route}/data/{id}',
                'update' => '{route}/update/{id}'
            ]
        ];
        $window->form->setStateButtons($window->form::STATE_UPDATE, ['info', 'save', 'cancel']);
        return $window;
    }

    /**
     * Действие "update" изменяет конфигурации служб.
     * 
     * @return Response
     */
    public function updateAction(): Response
    {
        /** @var Response $response */
        $response = $this->getResponse();
        /** @var \Gm\Http\Request $request */
        $request  = Gm::$app->request;

        /** @var \Gm\Panel\Data\Model\FormModel $model модель данных */
        $model = $this->getModel($this->defaultModel);
        if ($model === false) {
            $response
                ->meta->error(Gm::t('app', 'Could not defined data model "{0}"', [$this->defaultModel]));
            return $response;
        }

        // получение записи по идентификатору в запросе
        $form = $model->get();
        if ($form === null) {
            $form = $model;
        }

        // загрузка атрибутов в модель из запроса
        if (!$form->load($request->getPost())) {
            $response
                ->meta->error(Gm::t(BACKEND, 'No data to perform action'));
            return $response;
        }

        // валидация атрибутов модели
        if (!$form->validate()) {
            $response
                ->meta->error(Gm::t(BACKEND, 'Error filling out form fields: {0}', [$form->getError()]));
            return $response;
        }

        // сохранение атрибутов модели
        if (!$form->save()) {
            $response
                ->meta->error(
                    $form->hasErrors() ? $form->getError() : Gm::t(BACKEND, 'Could not save data')
                );
            return $response;
        }
        return $response;
    }
}
