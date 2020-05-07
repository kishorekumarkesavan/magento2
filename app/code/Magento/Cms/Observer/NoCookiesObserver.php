<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Observer;

use Magento\Framework\Event\ObserverInterface;

class NoCookiesObserver implements ObserverInterface
{
    /**
     * Cms page
     *
     * @var \Magento\Cms\Helper\Page
     */
    protected $_cmsPage;

    /**
     * ConfigInterface
     *
     * @var \Magento\Cms\Model\ConfigInterface
     */
    protected $_config;

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param \Magento\Cms\Helper\Page $cmsPage
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Cms\Model\ConfigInterface $config
     */
    public function __construct(
        \Magento\Cms\Helper\Page $cmsPage,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Cms\Model\ConfigInterface $config
    ) {
        $this->_cmsPage = $cmsPage;
        $this->_scopeConfig = $scopeConfig;
        $this->_config = $config;
    }

    /**
     * Modify no Cookies forward object
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $redirect = $observer->getEvent()->getRedirect();

        $pageId =$this->_config->getCmsNoCookiesPath();
        $pageUrl = $this->_cmsPage->getPageUrl($pageId);

        if ($pageUrl) {
            $redirect->setRedirectUrl($pageUrl);
        } else {
            $redirect->setRedirect(true)->setPath('cookie/index/noCookies')->setArguments([]);
        }
        return $this;
    }
}
