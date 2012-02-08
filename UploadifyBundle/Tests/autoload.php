<?php

$vendorDir = __DIR__.'/../vendor';
require_once $vendorDir.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => array($vendorDir.'/symfony/src', $vendorDir.'/bundles'),
    'Ruian'   => $vendorDir . '/../../../',
));
$loader->register();