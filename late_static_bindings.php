<?php

/**
 * late_static_bindings  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
/**
 * ��� ����� - ������� ����������� ���������� ��������� ������, ����� ����� ������
 * ������ �����. � ������ ����������� ������� ��� �����::����� - ����� �����, �.�. 
 * �����. � ������ ������� ������� ��� ����� ���������� �������. 
 * ������ ����� � ������ SELF �������� ��� �������� �������������
 * PHP

 * ���� ������, 
 * ����� ���������������� �������� ������������ ����������, ��������� �������� 
 * ��� ����� ����������� ������ � ������������ �������, �� ������ ����� ���� 
 * ����������� �������������� ������� ����� ������ � ����������� ����������, 
 * ������� � ��������� ������ �������, � �� ������ ������������� ������

 * ����� �������� ����� static ���������, 
 * ��� ���������� ������������ ��������� ��������������� ������, 
 * ������ ��������� ������� ���� ���������� � ������ ��� �������� 
 * ����� getStaticName(). ����� static ���� ���������, ����� ����������� 
 * ����� ����������, � ��� �������� ������������� self �������� ����� ��� � � 
 * ���������� ������� PHP.
 * 
 * 
 * ���������, �������� ������� (�, ����������, ������� ������ ���������� ������� �������) 
 * ����� ����� ����� ��������� �������, � ���, ��� PHP ��������� �������� ��� self::NAME 
 * �� ����� "����������" (����� ������� PHP ������������� � �������� ���, ������� 
 * ����� �������������� ������� Zend), � ��� static::NAME �������� ����� ���������� 
 * � ������ ������� (� ��� ������, ����� �������� ��� ����� ���������� � ������ Zend).
 * 
 */

/**
 * ������ � http://habrahabr.ru/blogs/php/23066/
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

$test0 =  $beerDrink->getName() ."\n"; // ������ Beer is: Beer!

$test1 =  $aleDrink->getName()  ."\n"; // ������ Ale is:  Beer!

//����� Ale ����������� ����� getName(), �� ��� ���� self ��� ��� ��������� �� 
//����� � ������� ��� ������������ (� ������ ������ ��� ����� Beer). 
//��� �������� � � PHP 5.3, �� ���������� ����� static. � ����� ���������� ������:


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
 * ������ � php.net
 */
// ������� � self, ����� ����������� ���������� �� ������������
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

$a = B::test(); // � ���� ������, ���� �� �������������� ������� � $this �� ������ 
                // ��� �� ����� B::who() � ��� - �. 
$b = A::test();
echo $a;

/// �������, ����� LSB ������������
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

$r = B1::test(); // � ��� ����� ��� ��������� B1 - �� ���� ��� � � ������ � $this


//In non-static contexts, the called class will be the class of the object instance. 
//Since $this-> will try to call private methods from the same scope, using static:: 
//may give different results. Another difference is that static:: 
//can only refer to static properties. 

// ������������� ��� ������������ ���������
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
//$c->test();   //fails �� ����� fatal



/*** ����������� �������� ������ � $this***/
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

// ������� 1
$t = new abc();
$a = $t->call(); // � ���� ������ ��������� abc->test() � ������ abc

// ������� 2
$t= new def();
$a2 = $t->call(); // � ���� ������ ��������� def->test() � ������ def
/*** ����� �������� ******/

?>