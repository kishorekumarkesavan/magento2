<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Test\Unit\Controller\Index;

use Magento\Cms\Model\ConfigInterface as ConfigInterface;

class IndexTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Cms\Controller\Index\Index
     */
    protected $controller;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $cmsHelperMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $forwardFactoryMock;

    /**
     * @var \Magento\Framework\Controller\Result\Forward|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $forwardMock;

    /**
     * @var \Magento\Framework\View\Result\Page|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resultPageMock;

    /**
     * @var string
     */
    protected $pageId = 'home';

    /**
     * Test setUp
     */
    protected function setUp()
    {
        $helper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $objectManagerMock = $this->createMock(\Magento\Framework\ObjectManagerInterface::class);
        $responseMock = $this->createMock(\Magento\Framework\App\Response\Http::class);
        $this->resultPageMock = $this->getMockBuilder(\Magento\Framework\View\Result\Page::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->forwardFactoryMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\ForwardFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->forwardMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\Forward::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->forwardFactoryMock->expects($this->any())
            ->method('create')
            ->willReturn($this->forwardMock);

        $scopeConfigMock = $this->createMock(\Magento\Framework\App\Config\ScopeConfigInterface::class);
        $cmsConfigMock = $this->createMock(\Magento\Cms\Model\Config::class);
        $this->requestMock = $this->createMock(\Magento\Framework\App\Request\Http::class);
        $this->cmsHelperMock = $this->createMock(\Magento\Cms\Helper\Page::class);
        $valueMap = [
            [\Magento\Framework\App\Config\ScopeConfigInterface::class,
                $scopeConfigMock,
            ],
            [\Magento\Cms\Helper\Page::class, $this->cmsHelperMock],
        ];
        $objectManagerMock->expects($this->any())->method('get')->willReturnMap($valueMap);
        $cmsConfigMock->expects($this->once())
            ->method('getCmsHomePath')
            ->willReturn($this->pageId);
        $this->controller = $helper->getObject(
            \Magento\Cms\Controller\Index\Index::class,
            [
                'response' => $responseMock,
                'objectManager' => $objectManagerMock,
                'request' => $this->requestMock,
                'resultForwardFactory' => $this->forwardFactoryMock,
                'scopeConfig' => $scopeConfigMock,
                'page' => $this->cmsHelperMock
            ]
        );
    }

    /**
     * Controller test
     */
    public function testExecuteResultPage()
    {
        $this->cmsHelperMock->expects($this->once())
            ->method('prepareResultPage')
            ->with($this->controller, $this->pageId)
            ->willReturn($this->resultPageMock);
        $this->assertSame($this->resultPageMock, $this->controller->execute());
    }

    /**
     * Controller test
     */
    public function testExecuteResultForward()
    {
        $this->forwardMock->expects($this->once())
            ->method('forward')
            ->with('defaultIndex')
            ->willReturnSelf();
        $this->assertSame($this->forwardMock, $this->controller->execute());
    }
}
