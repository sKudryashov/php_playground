<?php
/**
 * namespaces  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
require_once 'namespaces/namespace1.php';
//require_once 'namespaces/namespace2.php';

use namespaces\namespace1 as nmOne;
use namespaces\namespace2 as nmTwo;
use namespaces\space3 as nmThree;

$jore_statement = nmOne\joreGoHome(); //���� ������ ������� �� ���������� - ������� 1 - ����� ����������. 
$cl = new nmOne\Myclass();
$meth = $cl->testMeth();

$cl2 = new nmTwo\Myclass();
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