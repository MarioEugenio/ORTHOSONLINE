<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add('abstraction',  __DIR__.'/../vendor/abstractLayer');
$loader->add('FOS',  __DIR__.'/../vendor/bundles');
$loader->add('Bazinga',  __DIR__.'/../vendor/bundles');
$loader->add('Snowcap',  __DIR__.'/../vendor/bundles');
$loader->add('PunkAve',  __DIR__.'/../vendor/bundles');
$loader->add('Spraed',  __DIR__.'/../vendor/bundles');

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->add('', __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
}

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;