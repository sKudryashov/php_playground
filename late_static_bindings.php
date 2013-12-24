<?php

/**
 * late_static_bindings  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
/**
 * Что понял - позднее статическое связывание позволяет узнать, какой класс вызвал
 * данный метод. В случае статических вызовов это КЛАСС::Метод - левая часть, т.е. 
 * КЛАСС. В случае обычных вызовов это класс вызвавшего объекта. 
 * Кстати вызов с учетом SELF оставлен для обратной совместимости
 * PHP

 * Если кратко, 
 * новая функциональность позднего статического связывания, позволяет объектам 
 * все также наследовать методы у родительских классов, но помимо этого дает 
 * возможность унаследованным методам иметь доступ к статическим константам, 
 * методам и свойствам класса потомка, а не только родительского класса

 * Новое ключевое слово static указывает, 
 * что необходимо использовать константу унаследованного класса, 
 * вместо константы которая была определена в классе где объявлен 
 * метод getStaticName(). Слово static было добавлено, чтобы реализовать 
 * новый функционал, а для обратной совместимости self работает также как и в 
 * предыдущих версиях PHP.
 * 
 * 
 * Внутренне, основное отличие (и, собственно, причина почему связывание назвали поздним) 
 * между этими двумя способами доступа, в том, что PHP определят значение для self::NAME 
 * во время "компиляции" (когда симовлы PHP преобразуются в машинный код, который 
 * будет обрабатываться движком Zend), а для static::NAME значение будет определено 
 * в момент запуска (в тот момент, когда машинный код будет выполнятся в движке Zend).
 * 
 */

/**
 * ПРимер с http://habrahabr.ru/blogs/php/23066/
 */

class Beer {

    const NAME = 'Beer!';

      public function getName() {

          return self::NAME;

    }

}

class Ale extends Beer {

	const NAME = 'Ale!';

}

$beerDrink = new Beer;
$aleDrink = new Ale;

$test0 =  $beerDrink->getName() ."\n"; // ВЫдаст Beer is: Beer!

$test1 =  $aleDrink->getName()  ."\n"; // Выдаст Ale is:  Beer!

//Класс Ale унаследовал метод getName(), но при этом self все еще указывает на 
//класс в котором оно используется (в данном случае это класс Beer). 
//Это осталось и в PHP 5.3, но добавилось слово static. И снова рассмотрим пример:


class Beer2 {

  const NAME = 'Beer!';

  public function getName() {

	  return self::NAME;

  }

  public function getStaticName() {

	  return static::NAME;
  }

}



class Ale2 extends Beer2 {

  const NAME = 'Ale!';

}

$beerDrink = new Beer2;
$aleDrink = new Ale2;

$test2 =  $beerDrink->getName() ."\n"; // Beer
$test3 = $aleDrink->getName()  ."\n"; // Beer

$test4 =  $beerDrink->getStaticName() ."\n"; // Beer
$test5 = $aleDrink->getStaticName()  ."\n"; // Ale


/**
 * Пример с php.net
 */
// вариант с self, когда статическое связывание НЕ отрабатывает
class A {
    public static function who() {
        return __CLASS__; 
    }
    public static function test() {
        self::who(); 
    }
}

class B extends A {
    public static function who() {
        return __CLASS__;
    }
}

$a = B::test(); // в этом случае, если бы рассматривался вариант с $this то вызван 
                // был бы метод B::who() а так - а. 
$b = A::test();
echo $a;

/// Вариант, когда LSB отрабатывает
class A1 {
    
    public static function who() {
        return __CLASS__;
    }
    public static function test() {
        return static::who(); // Here comes Late Static Bindings
    }
}

class B1 extends A1 {
    public static function who() {
        return __CLASS__;
    }
}

$r = B1::test(); // а вот здесь уже вызовется B1 - то есть как и в случае с $this


//In non-static contexts, the called class will be the class of the object instance. 
//Since $this-> will try to call private methods from the same scope, using static:: 
//may give different results. Another difference is that static:: 
//can only refer to static properties. 

// использование вне статического контекста
class A3 {
    private function foo() {
        echo "success!\n";
        return __CLASS__;
    }
    public function test() {
        $a1 =  $this->foo();
        $a2 = static::foo();
    }
}

class B3 extends A3 {
   /* foo() will be copied to B, hence its scope will still be A and
    * the call be successful */
}

class C3 extends A3 {
    private function foo() {
        /* original method is replaced; the scope of the new one is C */
    }
}

$b = new B3();
$b->test();
$c = new C3();
//$c->test();   //fails да здесь fatal



/*** контрольная проверка случая с $this***/
class abc 
{
    public function __construct() {
        echo 'called abc construct';
    }
    function call()
    {
        return $this->test();
    }    
    function test()
    {
        return __CLASS__;
    }
}

class def extends abc
{    
    public function __construct() {
        echo 'called def construct';
    }
    function test() {
        return __CLASS__;
    }
}

// вариант 1
$t = new abc();
$a = $t->call(); // в этом случае вызовется abc->test() и вернет abc

// вариант 2
$t= new def();
$a2 = $t->call(); // в этом случае вызовется def->test() и вернет def
/*** конец проверки ******/

?>