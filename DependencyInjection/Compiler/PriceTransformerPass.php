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
 * Apple Price transformer compiler pass
 */
class PriceTransformerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $priceTransformerManager = $container->getDefinition('apple.appstore.pricetransformers');
        $priceTransformerMap = array();

        foreach ($container->findTaggedServiceIds('apple.appstore.pricetransformer') as $id => $attributes) {
            // Fix attributes
            $attributes = $this->fixAttributes($attributes);

            $priceTransformerClass = $container->getDefinition($id)->getClass();

            // Validate price transformer class
            try {
                // Get class from parameter
                if (strpos($priceTransformerClass, '%') === 0) {
                    $priceTransformerClass = $container->getParameter(trim($priceTransformerClass, '%'));
                }

                $refPriceTransformer = new \ReflectionClass($priceTransformerClass);
            } catch (\Exception $e) {
                throw new \RuntimeException(sprintf(
                    'Can\'t initialize "%s" price transformer',
                    $id
                ), 0, $e);
            }

            if (!$refPriceTransformer->implementsInterface('Apple\AppStore\PriceTransformerInterface')) {
                throw new \RuntimeException(sprintf(
                    'Price transformer "%s", class "%s" must be instance "Apple\AppStore\PriceTransformerInterface"',
                    $id, $refPriceTransformer->getName()
                ));
            }

            $priceTransformer = $container->get($id);

            // Get currency
            $currency = strtolower($priceTransformer->getPriceCurrency());

            $priceTransformerManager
                ->addMethodCall('add', array(new Reference($id)));

            $priceTransformerMap[$currency] = $id;
        }

        $container->setParameter('apple.appstore.pricetransformer_map', $priceTransformerMap);
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