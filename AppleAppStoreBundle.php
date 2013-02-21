<?php

/**
 * This file is part of the AppleAppStoreBundle package
 *
 * (c) Vitaliy Zhuk <zhuk2205@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Apple\AppStoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Apple\AppStoreBundle\DependencyInjection\Compiler\PriceTransformerPass;
use Apple\AppStoreBundle\DependencyInjection\Compiler\AppStorePass;
use Symfony\Component\Console\Application;

/**
 * Apple AppStore bundle
 */
class AppleAppStoreBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PriceTransformerPass());
        $container->addCompilerPass(new AppStorePass());
    }

    /**
     * {@inheritDoc}
     */
    public function registerCommands(Application $application)
    {
        $application->addCommands(array(
            new Command\StoresList()
        ));
    }
}