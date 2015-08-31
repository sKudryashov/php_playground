<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/25/15
 * Time: 1:17 PM
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('descent', false, false, false, false);
$msg = new AMQPMessage('descent starts!');
$channel->basic_publish($msg, '', 'descent');
echo "\nDescent status has been sent\n";
$channel->close();
$connection->close();