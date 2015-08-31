<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/27/15
 * Time: 1:31 PM
 * http://php.net/manual/en/gearman.examples-reverse.php
 */
echo "Starting worker\n";

$worker = new GearmanWorker();
$worker->addServer();

$worker->addFunction('reverse', 'fn_reverse');

function fn_reverse ($job) {
    echo "Received job: " . $job->handle() . "\n";
    $data = $job->workload();
    $data_size = $job->workloadSize();

    echo "Workload: $data ($data_size)\n";

    for ($x= 0; $x < $data_size; $x++) {
        echo "Sending status: " . ($x + 1) . "/$data_size complete\n";
        $job->sendStatus($x, $data_size);
        sleep(1);
    }

    $result= strrev($data);
    echo "Result: $result\n";
}
