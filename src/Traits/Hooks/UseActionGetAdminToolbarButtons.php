<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
declare(strict_types=1);

namespace PrestaShop\Module\Mbo\Traits\Hooks;

use Exception;
use PrestaShop\PrestaShop\Core\Action\ActionsBarButton;
use PrestaShop\PrestaShop\Core\Action\ActionsBarButtonsCollection;
use Tools;

trait UseActionGetAdminToolbarButtons
{
    /**
     * Hook actionGetAdminToolbarButtons.
     *
     * Retrieve buttons definitions to the Modules' toolbar
     *
     * @param array $params
     *
     * @return ActionsBarButtonsCollection
     */
    public function hookActionGetAdminToolbarButtons(array $params): ActionsBarButtonsCollection
    {
        /**
         * @var ActionsBarButtonsCollection $extraToolbarButtons
         */
        $extraToolbarButtons = $params['toolbar_extra_buttons_collection'];

        if (!in_array(Tools::getValue('controller'), self::CONTROLLERS_WITH_CONNECTION_TOOLBAR)) {
            return $extraToolbarButtons;
        }

        $toolbarButtons = $this->get('mbo.addons.toolbar')->getConnectionToolbar();

        foreach ($toolbarButtons as $toolbarButtonLabel => $toolbarButtonDescription) {
            $actionBarButton = new ActionsBarButton(
                $toolbarButtonLabel,
                $toolbarButtonDescription,
                $toolbarButtonDescription['desc']
            );
            $extraToolbarButtons->add($actionBarButton);
        }

        return $extraToolbarButtons;
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function bootUseGetAdminToolbarButtons(): void
    {
        if (method_exists($this, 'addAdminControllerMedia')) {
            $this->addAdminControllerMedia('loadMediaGetAdminToolbarButtons');
        }
    }

    /**
     * Add JS and CSS file
     *
     * @see \PrestaShop\Module\Mbo\Traits\Hooks\UseActionAdminControllerSetMedia
     *
     * @return void
     */
    protected function loadMediaGetAdminToolbarButtons(): void
    {
        $this->context->controller->addJs($this->getPathUri() . 'views/js/addons-connector.js?v=' . $this->version);
    }
}