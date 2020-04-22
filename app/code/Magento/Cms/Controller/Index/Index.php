<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Cms\Helper\Page as Page;
use Magento\Framework\App\Action\Action;
use Magento\Cms\Model\Config as Config;

/**
 * Home page. Needs to be accessible by POST because of the store switching.
 */
class Index extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Page
     */
    private $page;

    /**
     * Config
     *
     * @var \Magento\Cms\Model\Config
     */
    protected $_config;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     * @param ScopeConfigInterface|null $scopeConfig
     * @param Page|null $page
     * @param Config $config
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        ScopeConfigInterface $scopeConfig = null,
        Page $page = null,
        Config $config
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->scopeConfig = $scopeConfig ? : ObjectManager::getInstance()->get(ScopeConfigInterface::class);
        $this->page = $page ? : ObjectManager::getInstance()->get(Page::class);
        $this->_config = $config;
        parent::__construct($context);
    }

    /**
     * Renders CMS Home page
     *
     * @param string|null $coreRoute
     *
     * @return bool|ResponseInterface|Forward|ResultInterface|ResultPage
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($coreRoute = null)
    {
        $pageId = $this->_config->getCmsHomePath();
        $resultPage = $this->page->prepareResultPage($this, $pageId);
        if (!$resultPage) {
            /** @var Forward $resultForward */
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('defaultIndex');
            return $resultForward;
        }
        return $resultPage;
    }
}
