<?php
$root = realpath(__DIR__ . '/..');
$root_parts = explode(DIRECTORY_SEPARATOR, $root);

/**
 * Some absolute paths are defined here.
 */
defined('ROOT') || define('ROOT', implode('/', $root_parts) . '/');
defined('VIEW') || define('VIEW', implode('/', $root_parts) . '/views' . '/');
defined('MODEL') || define('MODEL', implode('/', $root_parts) . '/models' . '/');
defined('APP') || define('APP', implode('/', $root_parts) . '/app' . '/');