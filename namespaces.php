<?php
/**
 * namespaces  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
require_once 'namespaces/namespace1.php'; // namespaces doesn't work without requiring for functions
//require_once 'namespaces/namespace2.php';

use namespaces\namespace1 as nmOne;
use namespaces\namespace2 as nmTwo;
use namespaces\space3 as nmThree;

$jore_statement = nmOne\joreGoHome(); //тест вызова функции из неймспейса - вернула 1 - вызов правильный. 
$cl = new nmOne\Myclass();
$meth = $cl->testMeth();

$cl2 = new nmTwo\Myclass(); // in this case namespace works through autoloader. Without autoloader it won't work
$cl2->testMeth();

$cl = new Myclass();
$cl->testMeth();

$cl3 = new nmThree\Myclass();
$cl3->testMeth();

function __autoload($class)
{
    $path = str_replace('\\', '/', $class).'.php';
    $_path = explode('/', $path);
    $clear = array_pop($_path);
    $p= implode('/', $_path).'.php';
    require_once $p;
}