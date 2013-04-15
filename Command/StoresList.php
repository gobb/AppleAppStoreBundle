<?php

/**
 * This file is part of the AppleAppStoreBundle package
 *
 * (c) Vitaliy Zhuk <zhuk2205@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Apple\AppStoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Locale\Locale;

/**
 * Stores list
 */
class StoresList extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('apple:app-store:list')
            ->setDescription('View all app stores in Apple')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $appStoresManager = $this->getContainer()->get('apple.app_store');

        $storeManager = $appStoresManager->getStoreManager();

        $countries = Locale::getDisplayCountries('en');

        $output->writeln(sprintf('Exists <info>%s</info> stores.', count($storeManager)));
        $output->writeln('');
        foreach ($storeManager as $store) {
            /** @var $store \Apple\AppStore\AppStoreInterface */
            $output->writeln(sprintf(' - <comment>%s</comment>', strtoupper($store->getCountryISO())));

            $priceTransformer = $store->getPriceTransformer();

            $countryName = $countries[strtoupper($store->getCountryISO())];
            $output->writeln(sprintf('  %-10s<comment>%s</comment>', 'Country:', $countryName));
            $output->writeln(sprintf('  %-10s<info>%s</info>', 'Class:', get_class($store)));
            $output->writeln(sprintf('  %-10s<info>%s</info>', 'Currency:', $priceTransformer->getCurrency()));
            $output->writeln('');
        }

        $output->writeln('');
    }
}