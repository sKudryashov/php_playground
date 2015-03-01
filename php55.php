<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 12/24/13
 * Time: 4:43 PM
 */
//Generators added
function someRange ($start, $limit, $step) {
    if ($start < $limit) {
        throw new LogicException("Limit should be greater then start");
    }
    for ($i = $start; $i < $limit; $i += $step) {
        yield $i;
    }
}

echo 'Single digit odd numbers: ';



foreach (someRange(1, 50, 2) as $value) {
    echo "Yield generated $value \n";
}
// Full description of generators usage comparing with iterators
//https://wiki.php.net/rfc/generators#closing_a_generator

function readLine ($file) {
    $resource = @fopen($file, 'r');
    if(!$resource) {
        throw new LogicException("The $file cannot be opened");
    }
    while (!feof($resource)) {
        $line = fgets($resource);
        yield $line;
    }
    fclose($resource);
}

$readlineGenerator = readLine('streams/file.txt');

$lineContainer = [];
foreach ($readlineGenerator as $line) {
    $lineContainer[] = $line; // safety way to iterate through large amounts of data
}

//Any function which contains a yield statement is automatically a generator function.
//final class Generator implements Iterator {
//void  rewind();
//    bool  valid();
//    mixed current();
//    mixed key();
//    void  next();
//
//    mixed send(mixed $value);
//    mixed throw(Exception $exception);
//}

//Apart from the above the Generator methods behave as follows:
//
//rewind: Throws an exception if the generator is currently after the first yield.
//valid: Returns false if the generator has been closed, true otherwise.
//current: Returns whatever was passed to yield or null if nothing was passed or the generator is already closed.
//key: Returns the yielded key or, if none was specified, an auto-incrementing key or null if the generator is already
//closed.
//next:
//send: Sets the return value of the yield expression and resumes the generator (unless the generator is already closed).
//throw: Throws an exception at the current suspension point in the generator.