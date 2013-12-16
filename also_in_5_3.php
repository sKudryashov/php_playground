<?php

/**
 * also_in_5_3  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */

/**
 * Call Static - �� �� ��� � __call ������ � ����������� ���������
 */
class MethodTest {
    public function __call($name, $arguments) {
        // Note: value of $name is case sensitive.
        echo "Calling object method '$name' "
             . implode(', ', $arguments). "\n";
    }

    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments) {
        // Note: value of $name is case sensitive.
        echo "Calling static method '$name' "
             . implode(', ', $arguments). "\n";
    }
}

$obj = new MethodTest;
$obj->runTest('in object context');

MethodTest::runTest('in static context');  // As of PHP 5.3.0

/**
 * ���������� ����� __invoke ����������, ����� ������ �������� ������� ������ ��� �������
 */
class CallableClass
{
    public function __invoke($x)
    {
        var_dump($x);
    }
}
$obj = new CallableClass;
$obj(5);
var_dump(is_callable($obj));

/**
 * ������� � ������ 5.3 ����� heredoc ���������� �������� ����� NOWDOC ���������
 * � ��� ��� ����� - �� ������ Nowdoc �� �������������� ���������� .
 * �� ������ ��������� NOWDOC � ������� �� heredoc ����� ���� ��������� ������. 
 */
$str = <<<'EOD'
Example of string
spanning multiple lines
using nowdoc syntax.
EOD;

/* More complex example, with variables. */
class foo
{
    public $foo;
    public $bar;

    function foo()
    {
        $this->foo = 'Foo';
        $this->bar = array('Bar1', 'Bar2', 'Bar3');
    }
}

$foo = new foo();
$name = 'MyName';

echo <<<'EOT'
My name is "$name". I am printing some $foo->foo.
Now, I am printing some {$foo->bar[1]}.
This should not print a capital 'A': \x41
EOT;

//�������:
//My name is "$name". I am printing some $foo->foo.
//Now, I am printing some {$foo->bar[1]}.
//This should not print a capital 'A': \x41

/**
 * ����� ����� �������� fatal � �� �����
 */
class foo2 {
    public $bar = <<<'EOT'
bar
EOT;
}

?>