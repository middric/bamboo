<?php
include_once '/usr/share/php/BBC/Test/phpunit-bootstrap.php';
$phpunitPath = realpath(dirname(__FILE__).'/../..');
ini_set(
    'include_path',
    "$phpunitPath/src/main/lib:".
    "$phpunitPath/src/main/lib-test:".
    "$phpunitPath/src/devel:".
    ini_get('include_path')
);
