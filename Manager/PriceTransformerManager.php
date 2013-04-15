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

use Apple\AppStore\PriceTransformerInterface;

/**
 * Price transformers manager
 */
class PriceTransformerManager extends ManagerBag
{
    /**
     * @var array
     */
    protected $storage = array();

    /**
     * Add price transformer to collection
     *
     * @param PriceTransformerInterface $priceTransformer
     * @return PriceTransformerManager
     */
    public function add(PriceTransformerInterface $priceTransformer)
    {
        $this->storage[strtolower($priceTransformer->getCurrency())] = $priceTransformer;

        return $this;
    }
}