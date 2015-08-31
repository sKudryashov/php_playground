<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/27/15
 * Time: 1:55 PM
 * http://php.net/manual/en/gearman.examples-reverse-bg.php
 */
$client= new GearmanClient();
$client->addServer();
$job = $client->doBackground('reverse', 'reverse bg test');
if ($gmclient->returnCode() != GEARMAN_SUCCESS) {
    echo "bad return code\n";
    exit;
}
echo "done!\n Job data: $job";