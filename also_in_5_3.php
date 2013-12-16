<?php

/**
 * also_in_5_3  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */

/**
 * Call Static - то же что и __call только в статическом контексте
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
 * Магический метод __invoke вызывается, когда скрипт пытается вызвать объект как функцию
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
 * Начиная с версии 5.3 кроме heredoc синтаксиса доступен также NOWDOC синтаксис
 * в чем его фишка - во первых Nowdoc не интерпретирует переменные .
 * Во вторых выражение NOWDOC в отличие от heredoc может быть свойством класса. 
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

//выведет:
//My name is "$name". I am printing some $foo->foo.
//Now, I am printing some {$foo->bar[1]}.
//This should not print a capital 'A': \x41

/**
 * Здесь также никакого fatal а не будет
 */
class foo2 {
    public $bar = <<<'EOT'
bar
EOT;
}

?>