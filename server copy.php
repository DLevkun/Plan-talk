<?php

use Workerman\Worker;

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */


$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';

require __DIR__.'/vendor/autoload.php';

$context = array(
    'ssl' => array(
        'local_cert'  => __DIR__.'/public/ssl/domain.csr',
        'local_pk'    => __DIR__.'/public/ssl/domain.key',
        'verify_peer' => false,
    )
);
$wsWorker = new Worker('websocket://0.0.0.0:2346');
$wsWorker->count = 4;

$wsWorker->onConnect = function($connection) {
    echo "New connection\n";
};

$wsWorker->onMessage = function($connection) {
    foreach($wsWorker->connections as $clientConnection) {
         $clientConnection->send($data);
    }
};

$wsWorker->onClose = function($connection) {
    echo "Connection closed\n";
};

Worker::runAll();

