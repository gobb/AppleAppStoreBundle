<?php

/**
 * This file is part of the AppleAppStoreBundle package
 *
 * (c) Vitaliy Zhuk <zhuk2205@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Apple\AppStoreBundle\Tests\Manager;

use Apple\AppStoreBundle\Manager\ManagerBag;

/**
 * Default manager bag for testing functionality
 */
class ManagerBagTesting extends ManagerBag
{
    /**
     * @var array
     */
    protected $storage = array();

    /**
     * Add item to collection
     *
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        $this->storage[$key] = $value;
    }
}