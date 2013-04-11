<?php

include_once '/usr/share/php/BBC/Test/phpunit-bootstrap.php';
$phpunitPath = realpath(dirname(__FILE__) . '/../..');
ini_set(
    'include_path',
    "$phpunitPath/main/lib:" .
    "$phpunitPath/main/lib-test:" .
    "$phpunitPath/devel:" .
    ini_get('include_path')
);

$_SERVER['PAL_WEBAPP'] = 'bamboo';
$_SERVER['PAL_WEBAPP_ROOT'] = realpath(dirname(__FILE__) . '/../..');