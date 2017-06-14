<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Tax\Model\Rate;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Convert\DataObject as Converter;
use Magento\Tax\Api\TaxRateRepositoryInterface;
use Magento\Tax\Model\Rate\Provider as RateProvider;

/**
 * Tax rate source model.
 */
class Source implements \Magento\Framework\Data\OptionSourceInterface
{
    /** @var array */
    protected $options;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /** @var Converter */
    protected $converter;

    /** @var RateProvider */
    protected $rateProvider;

    /**
     * Initialize dependencies.
     *
     * @param TaxRateRepositoryInterface $taxRateRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Converter $converter
     * @param RateProvider $rateProvider
     */
    public function __construct(
        TaxRateRepositoryInterface $taxRateRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Converter $converter,
        RateProvider $rateProvider = null
    ) {
        $this->taxRateRepository = $taxRateRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->converter = $converter;
        $this->rateProvider = $rateProvider ?: ObjectManager::getInstance()->get(RateProvider::class);
    }

    /**
     * Retrieve all tax rates as an options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->setPageSize(RateProvider::PAGE_SIZE)
                ->setCurrentPage(1)
                ->create();

            $this->options = $this->rateProvider->toOptionArray($searchCriteria);
        }

        return $this->options;
    }
}
