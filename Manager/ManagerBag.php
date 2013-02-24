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
 * Abstract manager bag
 */
abstract class ManagerBag implements \Iterator, \Countable
{
    /**
     * @var array
     */
    protected $storage;

    /**
     * Implements \Iterator
     */
    public function current()
    {
        return current($this->storage);
    }

    /**
     * Implements \Iterator
     */
    public function key()
    {
        return key($this->storage);
    }

    /**
     * Implements \Iterator
     */
    public function next()
    {
        return next($this->storage);
    }

    /**
     * Implements \Iterator
     */
    public function rewind()
    {
        return reset($this->storage);
    }

    /**
     * Implements \Iterator
     */
    public function valid()
    {
        return (bool) $this->current();
    }

    /**
     * Implements \Countable
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * Get items by key
     *
     * @param string $key
     */
    public function get($key)
    {
        return $this->storage[strtolower($key)];
    }
}