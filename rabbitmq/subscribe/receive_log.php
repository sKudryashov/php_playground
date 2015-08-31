<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/25/15
 * Time: 6:19 PM
 * https://www.rabbitmq.com/tutorials/tutorial-three-php.html
 */
//launch: $ php receive_logs.php > logs_from_rabbit.log $ php receive_logs.php $ php emit_log.php

require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);

list($queue_name, , ) = $channel->queue_declare('', false, false, true, false);
$channel->queue_bind($queue_name, 'logs');

$callback = function ($msg) {
    echo ' [x] ', $msg->body, "\n";
};

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);



while (count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();