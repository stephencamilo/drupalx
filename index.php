<?php

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/vendor/autoload.php';

use Core\Includes\Bootstrap;
$bootstrap = new Bootstrap;

$bootstrap->drupal_bootstrap(Bootstrap::$drupal_bootstrap_full);
menu_execute_active_handler();