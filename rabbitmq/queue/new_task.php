<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/25/15
 * Time: 4:09 PM
 * https://www.rabbitmq.com/tutorials/tutorial-two-php.html
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, false, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "Hello World!";
$msg = new AMQPMessage($data, ['delivery_mode' => 2]);

$channel->basic_publish($msg, '', 'task_queue');

echo " [x] Sent ", $data, "\n";
$channel->close();
$connection->close();