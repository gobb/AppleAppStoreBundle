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

/**
 * Manager bag test
 */
class ManagerBagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Base test manager
     */
    public function testDefault()
    {
        $mb = new ManagerBagTesting;
        $this->assertCount(0, $mb);
        $mb->add('foo', 'bar');
        $this->assertCount(1, $mb);
        $mb->add('bar', 'foo');
        $this->assertCount(2, $mb);
    }
}