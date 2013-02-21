<?php

/**
 * This file is part of the AppleAppStoreBundle package
 *
 * (c) Vitaliy Zhuk <zhuk2205@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Apple\AppStoreBundle\Manager;

/**
 * AppStore manager
 */
class AppStoreManager implements AppStoreManagerInterface
{
    /**
     * @var PriceTransformerManager
     */
    protected $priceTransformerManager;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * Construct
     *
     * @param StoreManager $storeManager
     * @param PriceTransformerManager $priceTransformerManager
     */
    public function __construct(StoreManager $storeManager, PriceTransformerManager $priceTransformerManager)
    {
        $this->storeManager = $storeManager;
        $this->priceTransformerManager = $priceTransformerManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getPriceTransformerManager()
    {
        return $this->priceTransformerManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getStoreManager()
    {
        return $this->storeManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getStore($countryISO)
    {
        return $this->storeManager->get($countryISO);
    }

    /**
     * {@inheritDoc}
     */
    public function getPriceTransformer($currency)
    {
        return $this->priceTransformerManager->get(strtolower($currency));
    }
}