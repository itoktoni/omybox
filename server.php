<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */


if (isset($_GET['info'])) {
    phpinfo();
} else if (isset($_GET['install'])) {

    if (!file_exists(base_path() . '/.htaccess')) {

        copy(base_path() . '/public/default/.htacces', '.htaccess');
    }

    if (!file_exists(base_path() . '/env/local.env')) {

        copy(base_path() . '/.env', 'env/local.env');
        copy(base_path() . '/.env', 'env/production.env');
    }

    if (!file_exists(base_path() . '/config/website.php')) {

        copy(base_path() . '/public/default/website.php', 'config/website.php');
    }

    if (!file_exists(base_path() . '/database/database.sqlite')) {

        copy(base_path() . '/public/default/website.php', 'config/website.php');
    }
} else if (isset($_GET['https'])) {
    if (!file_exists(base_path() . '/.htaccess')) {

        copy(base_path() . '/public/default/.htaccess', '.htaccess');
    }
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/' . $uri)) {
    return false;
}

require_once __DIR__ . '/index.php';
