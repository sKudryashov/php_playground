<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/25/15
 * Time: 4:20 PM
 * https://www.rabbitmq.com/tutorials/tutorial-two-php.html
 * to manage queues use this set of commands
 * sudo rabbitmqctl list_queues name messages_ready messages_unacknowledged
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, false, false, false);
echo "\n\nWaiting for messages for the worker:\n";

$callback = function ($msg) {
    echo " [x] Received ", $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done", "\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};
$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}