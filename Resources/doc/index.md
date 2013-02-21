Getting Started with AppleAppStoreBundle
========================================

## Prerequisites

This version of bundre requires Symfony 2.1+ and PHP >= 5.3.3

## Installation

### Step1: Dowload AppleAppStoreBundle using composer

```js
{
    "required": {
        "apple/app-store-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

```bash
$ php composer.phar update apple/app-store-bundle
```

Composer will install the bundle to your project's `vendor/apple` directory.

### Step 2: Enable bundle

Enable bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Apple\ApnPushBundle\AppleApnPushBundle(),
    );
}
```

## Usage AppStore component

### Store
Get app stores manager from service container:

```php
$appStoresManager = $container->get('apple.app_store');
```

Get app store by country ISO code:

```php
$usAppStore = $appStoresManager->getStore('us');
```

**Attention:**
> All code stores configuration from [ISO_3166-1_alpha-2] (http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)

## Price transformer

Get price transformer by currency:

```php
$usdPriceTransformer = $appStoresManager->getPriceTransformer('usd');
```
