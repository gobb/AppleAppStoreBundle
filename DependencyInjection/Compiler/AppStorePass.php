<?php

/**
 * This file is part of the AppleAppStoreBundle package
 *
 * (c) Vitaliy Zhuk <zhuk2205@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Apple\AppStoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Apple\AppStore\AppStores;

/**
 * Apple AppStore compiler pass
 */
class AppStorePass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $storeManager = $container->getDefinition('apple.app_store.stores');
        $priceTransformerMap = $container->getParameter('apple.app_store.pricetransformer_map');

        foreach ($container->findTaggedServiceIds('apple.app_store.store') as $id => $attributes) {
            $attributes = $this->fixAttributes($attributes);

            $attributes += array(
                'pricetransformer' => null
            );

            // Validate app store class
            $appStoreClass = $container->getDefinition($id)->getClass();

            try {
                $parametersBag = $container->getParameterBag();
                $appStoreClass = $parametersBag->resolveValue($appStoreClass);

                // Create new reflection for control class not found error
                $refAppStore = new \ReflectionClass($appStoreClass);
            } catch (\ReflectionException $e) {
                throw new \RuntimeException(sprintf(
                    'Can\'t initialize "%s" app store.',
                    $id
                ), 0, $e);
            }

            // Check price transformer
            if ($attributes['pricetransformer']) {
                $attributes['pricetransformer'] = strtolower($attributes['pricetransformer']);

                if (!isset($priceTransformerMap[$attributes['pricetransformer']])) {
                    throw new \RuntimeException(sprintf(
                        'Undefined price transformer by currency "%s". Allowed currency: "%s".',
                        $attributes['pricetransformer'],
                        implode('", "', array_keys($priceTransformerMap))
                    ));
                }

                $definition = $container->getDefinition($id);
                $definition->addMethodCall('setPriceTransformer', array(
                    new Reference($priceTransformerMap[$attributes['pricetransformer']])
                ));
            }

            $storeManager
                ->addMethodCall('add', array(new Reference($id)));
        }
    }

    /**
     * Fix attributes
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function fixAttributes(array $attributes)
    {
        $result = array();

        foreach ($attributes as $attr) {
            $result = array_merge($result, $attr);
        }

        return $result;
    }
}