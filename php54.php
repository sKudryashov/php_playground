<?php
/*
    PHP 5.4.0 offers a wide range of new features:

    Support for traits has been added.
    Short array syntax has been added, e.g. $a = [1, 2, 3, 4]; or $a = ['one' => 1, 'two' => 2,
        'three' => 3, 'four' => 4];.
    Function array dereferencing has been added, e.g. foo()[0].
    Closures now support $this.
    <?= is now always available, regardless of the short_open_tag php.ini option.
    Class member access on instantiation has been added, e.g. (new Foo)->bar().
    Class::{expr}() syntax is now supported.
    Binary number format has been added, e.g. 0b001001101.
    Improved parse error messages and improved incompatible arguments warnings.
    The session extension can now track the upload progress of files.
    Built-in development web server in CLI mode.
*/


/**
 * Traits
 */
trait oneZTrait
{

    function listOne()
    {
        return __METHOD__ + 1;
    }

    function listTwo()
    {
        return __METHOD__ + 2;
    }
}

trait twoZTrait
{
//    function listTwo() collision of the methods will occurs if we use this two traits together
//    {
//        return __METHOD__ + 2;
//    }

    function listThree()
    {
        return __METHOD__ + 3;
    }
}

class oneZClass
{
    use oneZTrait;

    public function __construct()
    {
        $val = $this->listOne();
        return $val;
    }
}

class twoZClass
{
    use twoZTrait, oneZTrait;

    public function __construct()
    {
        $val = $this->listTwo();

        return $val;
    }
}

goto LabelOne;

echo "Test goto one";

LabelOne:
echo "Test goto two"; // returns goto two

// launching embedded php server
// $ php -S 0.0.0.0:8000
