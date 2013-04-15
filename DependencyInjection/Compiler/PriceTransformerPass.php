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
        $priceTransformerManager = $container->getDefinition('apple.app_store.pricetransformers');
        $priceTransformerMap = array();

        foreach ($container->findTaggedServiceIds('apple.app_store.pricetransformer') as $id => $attributes) {
            // Fix attributes
            $attributes = $this->fixAttributes($attributes);

            $priceTransformerClass = $container->getDefinition($id)->getClass();

            // Validate price transformer class
            try {
                $parametersBag = $container->getParameterBag();
                $priceTransformerClass = $parametersBag->resolveValue($priceTransformerClass);

                $refPriceTransformer = new \ReflectionClass($priceTransformerClass);
            } catch (\ReflectionException $e) {
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
            $currency = strtolower($priceTransformer->getCurrency());

            $priceTransformerManager
                ->addMethodCall('add', array(new Reference($id)));

            $priceTransformerMap[$currency] = $id;
        }

        $container->setParameter('apple.app_store.pricetransformer_map', $priceTransformerMap);
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