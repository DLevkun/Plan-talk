<?php
use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

$context = array(
    'ssl' => array(
        'local_cert'  => __DIR__.'/public/ssl/domain.csr',
        'local_pk'    => __DIR__.'/public/ssl/domain.key',
        'verify_peer' => false,
    )
);
$wsWorker = new Worker('websocket://0.0.0.0:2346', $context);
$wsWorker->count = 4;

$wsWorker->onConnect = function($connection) {
    echo "New connection\n";
};

$wsWorker->onMessage = function($connection, $data) use ($wsWorker) {
    foreach($wsWorker->connections as $clientConnection) {
         $clientConnection->send($data);
    }
};

$wsWorker->onClose = function($connection) {
    echo "Connection closed\n";
};

Worker::runAll();
