<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/25/15
 * Time: 1:26 PM
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('descent', false, false, false, false);
echo "\n\nWaiting for msgs:\n";

$callback = function ($msg) {
    $instance = get_class($msg);
    echo "\n Received: $msg->body and instance of: $instance";

};
$channel->basic_consume('descent', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}