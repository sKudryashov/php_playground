<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/25/15
 * Time: 6:18 PM
 * https://www.rabbitmq.com/tutorials/tutorial-three-php.html
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->exchange_declare('log', 'fanout', false, false, false);
$data = implode(' ', array_slice($argv, 1));

if(empty($data)) $data = "info: Hello World!";
$msg = new AMQPMessage($data);
$channel->basic_publish($msg, 'logs');
echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();