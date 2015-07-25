<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 12/24/13
 * Time: 4:43 PM
 */
//Generators added
function someRange ($start, $limit, $step) {
    if ($start > $limit) {        //#1
        throw new LogicException("Limit should be greater then start");
    }
    for ($i = $start; $i < $limit; $i += $step) { // #2 when the external iterator starts spin this generator func
        yield $i;                                 // we are startin from this point #2 but point #1 calls only 1 time on start
    }
}

echo 'Single digit odd numbers: ';

$someRange = someRange(1, 50, 2); // in this case generator only initialized not called and $someRange variable is
                                    //Generator object instance

foreach ($someRange as $value) {
    echo "Yield generated $value \n";
}
// Full description of generators usage comparing with iterators
//https://wiki.php.net/rfc/generators#closing_a_generator

function readOneLine ($file) {
    $resource = @fopen($file, 'r');
    if(!$resource) {
        return;
    }
    while (!feof($resource)) { // and sure generator start second and other iterations from this point
        $line = fgets($resource);
        yield $line;
    }
    fclose($resource);
}

$readlineGenerator = readOneLine('streams/file.txt');

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

class DataContainer implements IteratorAggregate {
    protected $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function &getIterator() {
        foreach ($this->data as $key => &$value) {
            yield $key => $value;
        }
    }
}
$dataContainerIterator = new DataContainer([1=>11, 2=>22, 3=>33]);
foreach ($dataContainerIterator as $key=>$value) {
    printf('Data container iterator: $key - %s, $value - %s', $key, $value);
}

function gen() {
    yield 'a';
    yield 'b';
    yield 'key' => 'c';
    yield 'd';
    yield 10 => 'e';
    yield 'f';
}

foreach (gen() as $key => $value) {
    echo $key, ' => ', $value, "\n";
}

// outputs:
//0 => a
//1 => b
//key => c
//2 => d
//10 => e
//11 => f



