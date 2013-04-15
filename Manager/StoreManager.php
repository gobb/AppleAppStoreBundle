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

use Apple\AppStore\AppStoreInterface;

/**
 * Stores manager
 */
class StoreManager extends ManagerBag
{
    /**
     * @var array
     */
    protected $storage = array();

    /**
     * Add app store to collection
     *
     * @param AppStoreInterface $appStore
     * @return StoreManager
     */
    public function add(AppStoreInterface $appStore)
    {
        $this->storage[strtolower($appStore->getCountryISO())] = $appStore;

        return $this;
    }
}