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
 * Interface for control all stores and price manager
 */
interface AppStoreManagerInterface
{
    /**
     * Get price transformer manager
     *
     * @return PriceTransformerManager
     */
    public function getPriceTransformerManager();

    /**
     * Get stores manager
     *
     * @return StoreManager
     */
    public function getStoreManager();
}