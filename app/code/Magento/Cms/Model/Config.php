<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Model;

use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Cms\Model\ConfigInterface as ConfigInterface;

/**
 * Contact module configuration
 */
class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }
    /**
     * {@inheritdoc}
     */
    public function getCmsNoRoutePath(){
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_NO_ROUTE_PAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCmsNoCookiesPath(){
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_NO_COOKIES_PAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCmsHomePath(){
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_HOME_PAGE,
            ScopeInterface::SCOPE_STORE
        );
    }
   
}
