<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Model;

/**
 * Cms module configuration
 *
 * @api
 * @since 100.2.0
 */
interface ConfigInterface
{
    /**
     * CMS no-route config path
     */
    const XML_PATH_NO_ROUTE_PAGE = 'web/default/cms_no_route';

    /**
     * CMS no cookies config path
     */
    const XML_PATH_NO_COOKIES_PAGE = 'web/default/cms_no_cookies';

    /**
     * CMS home page config path
     */
    const XML_PATH_HOME_PAGE = 'web/default/cms_home_page';

    /**
     * Return CMS no route page id
     *
     * @return string
     * @since 100.2.0
     */
    public function getCmsNoRoutePath();

    /**
     * Return CMS no cookie page id
     *
     * @return string
     * @since 100.2.0
     */
    public function getCmsNoCookiesPath();

    /**
     * Return CMS no cookie page id
     *
     * @return string
     * @since 100.2.0
     */
    public function getCmsHomePath();
}
