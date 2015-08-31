<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 8/27/15
 * Time: 1:31 PM
 * http://php.net/manual/en/gearman.examples-reverse.php
 */
$client = new GearmanClient();
$client->addServer();

echo 'Sending job';
do {
    $result = $client->doNormal('reverse', 'Hello!');
    switch($client->returnCode()) {
        case GEARMAN_WORK_DATA:
            echo "\nData $result\n";
            break;
        case GEARMAN_WORK_STATUS:
            list($numerator, $denominator)= $client->doStatus();
            echo "Status: $numerator/$denominator complete\n";
            break;
        case GEARMAN_WORK_FAIL:
            echo "Failed\n";
            exit;
        case GEARMAN_SUCCESS:
            echo "Success: $result\n";
            break;
        default:
            echo "RET: " . $client->returnCode() . "\n";
            exit;
    }
} while($client->returnCode() != GEARMAN_SUCCESS);