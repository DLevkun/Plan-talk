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

<<<<<<< HEAD
$wsWorker->onMessage = function($connection, $data) {
=======
$wsWorker->onMessage = function($connection, $data) use ($wsWorker) {
>>>>>>> 2159bcbb6f8630c022f37584d4084bd7ba1443bf
    foreach($wsWorker->connections as $clientConnection) {
         $clientConnection->send($data);
    }
};

$wsWorker->onClose = function($connection) {
    echo "Connection closed\n";
};

Worker::runAll();
