<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Framework\App\Action\Action;
use Magento\Cms\Model\ConfigInterface;

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
     * @var Page
     */
    private $page;

    /**
     * ConfigInterface
     *
     * @var \Magento\Cms\Model\ConfigInterface
     */
    protected $_config;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     * @param ConfigInterface $config
     * @param PageHelper|null $page
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        ConfigInterface $config,
        PageHelper $page = null
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_config = $config;
        $this->page = $page ? : ObjectManager::getInstance()->get(PageHelper::class);
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
            /** @var For  ward $resultForward */
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('defaultIndex');
            return $resultForward;
        }
        return $resultPage;
    }
}
