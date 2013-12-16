<?php
/**
 * this is OOP chapter practical
 */

var_dump(3*4);
/**
 * Objects in php5 passed by reference therefore $myClassInstance and $copyInstance
 * linked at the one object
 */
// Абсолютно легальное объявление
//$myClassInstance = new myClass();
//$copyInstance = $myClassInstance();s
// кстати если у объекта $b есть __get то в результате $a = $obj->b = 8;
// он НЕ вызовется

/**
 * Кстати говоря - если на объект существует хотя бы одна ссылка, деструктор объекта 
 * вызван не будет
 */
/**
 * Кстати говоря - если хотя бы один метод в классе объявлен как абстрактный - 
 * весь метод должен быть абстрактным 
 */

 interface  jimone{
  function one(); // у интерфейсов нет тела 
  function two();
}

interface jimtwo{
  function three();
  //function two(); two interfaces cant contains identical methods
}
// class cant implements two interfaces with identical methods abstraction
class jim implements jimone, jimtwo{

  function one(){
      echo '!one';
  }

  function two (){
      echo '!two';
  }

  function three(){
      echo '!three';
  }
}

$j = new jim();
$j->two();


abstract class spaceAbstract {
    public function  __construct() {
        echo 'constructor called'; // constructor called normally
    }
    abstract protected function checkme(); // и у абстрактных методов нет тела (что логично)

    abstract protected function heyyou();

    abstract static function makemestatic();
}

class space extends spaceAbstract{
    protected function checkme() {
       echo 'is_check';
    }
    static function makemestatic(){
        echo 'makemestatic';
    }
    public function checkyou(){
        self::checkme();
    }
    public function heyyou(){
        $this->makemestatic();
        echo 'heyyou'; //its very surprisingly for me but access level
                        //two method that advertise in abstract method does
                        //not affect to access level inheritance method

    }
}
space::makemestatic(); // makemestatic called normally
$s = new space();
$ff= $s->makemestatic();
$s->checkyou();
$s->heyyou(); // unbeliveably, its work!

interface rtyt{
   function bot();
}
interface asee extends rtyt{ // нормально - интерфейсы могут наследоваться друг от друга
    function botsss();
}


class st implements asee{
    function botsss(){
        
    }
    function bot(){
        
    }
}
$s = new st();

$one = testNoSTaticCall::run(); // да работает. Еще раз убедился что паблик функции можно вызывать без вызова класса
                                // при этом $this - undefined
class testNoSTaticCall
{
    public function run(){
        $thistest = $this; // если не о
        return 1;         
    }
}
$tt = new testNoSTaticCall;
// тест $this - для разных случаев 
$tt->run(); // $this = testNoSTaticCall object
$tt::run(); // а здесь $this тоже недоступен. Между прочим. Даже после инициализации класса - при таком вызове
            // хорошо что догадался.

$st_is = null;
class foo {
    
    function __construct()
    {
        $st_is = __METHOD__ . PHP_EOL;
    }
    
    function __destruct()
    {
        $st_is = __METHOD__;
    }
    
    function __set($name, $value) {
        $this->$name = $value; // 
    }
    function __toString() {
        return  'tormoz';
    }
}

$a = new foo();
$b = $a;

// попробуем прямой вызов magic методов
$v = $b->__toString(); // работает
$b->__set('name', 'value'); // работает но два раза вызывается. т.к. в самом объекте назначаем свойство которого нет
                            // и __set вызывается на этот раз уже из самого объекта
unset($a); // здесь деструктор не вызовется. потому как на объект существует ссылка
           // В этом случае он вызовется в конце выполнения скрипта 
unset($b); // здесь вызовется

// контроль вызова деструктора по завершению работы скрипта
class controlNotUnsettedDectructor
{
    public function __destruct() {
       echo 'checks when the destructor calling'; //  да срабатывает по завершении работы скрипта                                                    
    }
}
$cn = new controlNotUnsettedDectructor();
//die(); // по вызову die(); автоматически вызывается деструктор 
interface object_iface
{
    public function stateone();
}

class BETA 
{
    private function zozhik()
    {
        $haram = 1;
    }
    public function uraura()
    {
        $a = 'dzen';
    }
}
// кстати константы класса могут хранить только скалярные значения
class Object extends BETA implements object_iface {
    
    private $_html;
    private $array = array();
    public  $serialize = null;
    public  $unserialize = null;
    public $object1;
    public $object2;
    
    public function __call($name, $arguments) {
        $this->_name = $name;
        $this->_arguments = $arguments;
    }
    private function testPrivatCallWith__Call()
    {
        echo 'yep!';
    }
    public function stateone() {
        echo 'stateone';
    }

    public function __destruct() {
        $agga = '1';
        return $this;
    }

    public function  __construct() {       
        $this->chunk();
    }
    public function chunk()
    {
        
        $this->_html = '<div><b>Ura</b></div>';
    }
    function  __toString() { // fatal
        return $this->_html;
    }

    // if(isset($o->a)){}
    function  __isset($name) {
        if($this->{$name}){
            return true;
        }
    }
 // __unset разустановка св-ва класса
    function  __unset($name) {
        echo $name;
    }
    // вызывается при var_export() 
    function  __set_state($array) {
        $this->array = $array;
        return 'echo "secret labs"';
    }

    function  __get($name) {
        if($this->{$name}){
            return $this->{$name};
        };
    }
    
    // Этот магический метод вызывается при вызове функции clone($object);
    function __clone(){
        // делает копию данного объекта, в противном случае
        // указатель будет указывать на тот же объект
        // ага при такой конструкции бесконечный цикл
        //$this->object1 = clone $this;
        return $this->object1;
    }

    /**
     *  serialize - unserialize
     * Кстати:
     * It is not possible for __sleep() to return names of 
     * private properties in parent classes. 
     * Doing this will result in an E_NOTICE level error.
     * Instead you may use the Serializable interface.
     */
    function  __sleep() { // serialize sleep
        // если этот метод не возвращает ничего - то вылетит нотайс
        $this->serialize = true;
        return $this;
    }
    function  __wakeup() {
        return $this;
    }
     
}

$o = new Object();
$clone = clone($o);
//$a = $o;
$o->zozhik();
$o->uraura();
$o->testPrivatCallWith__Call(); // private метод. Попадает в __call т.к. туда попадают все 
                                // вызовы так или иначе недоступных методов
echo $o;
$is = $o->_html; //есть вызов __get так как html - private свойство
$is = $o->_test_get; 
if($o->_html){// __get
    $out = $o->_html;
    echo $out; //
}

if(isset($o->serialize)){ // __isset()
    $st = true;    
}

/**
 * Вот это не совсем правильное использование unserialize
 */
$ser = serialize($o); // __sleep() - вернул сериализованный объект

//$st = unserialize($o); // вернул false так как мы пытаемся рассериализовать несериализованный объект
$ser_un = unserialize($ser); // странно. Не получается. Вызывается не wakeup а почему то destructor
unset ($o); // __unset();


/**
 * Попробуем Sleep Wakeup с другим объектом
 * Здесь видно что принцип похоже немного другой 
 * из Sleep мы возвращаем массив свойств класса
 * А когда вызывается Wakeup - очевидно вызов идет через
 * конструктор
 */
class Connection
{
    protected $link;
    private $server, $username, $password, $db;
    
    public function __construct($server, $username, $password, $db)
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->connect();
    }
    
    private function connect()
    {
        $this->link = mysql_connect($this->server, $this->username, $this->password);
        mysql_select_db($this->db, $this->link);
    }
    
    public function __sleep()
    {
        return array('server', 'username', 'password', 'db');
    }
    
    public function __wakeup()
    {
        $this->connect();
    }
}
$connection = new Connection('localhost', 'root', '333888', 'luvshop');
$data = serialize($connection); // получается что при сериализации нужно 
                                //вернуть список свойств объекта в виде массива
$st = unserialize($data); // да вызвался нормально и $st тепер наш объект

class testConstr {

    public function  __construct() {
        echo __METHOD__; 
    }

    public function testConstr(){
        echo 'testConstr';
    }
}
// двойного вызова конструктора нет
$v = new testConstr();

class finaltest
{
    // protected - private
    protected final function aboo()
    {
        echo __METHOD__;
    }
    public function callAboo()
    {
        $this->aboo();
    }
}

$ft = new finaltest();
$ft->callAboo();
unset($ft);


class fooone
{
    public $foo = 'bar';
    protected $baz = 'bat';
    private $qux = 'bingo';

    function __construct()
    {
        $vars = get_object_vars($this);
    }
}

class bar extends fooone {
    function __construct()
    {
        $vars = get_object_vars($this);
    }
}
class baz {
    function __construct() {
        $foo = new fooone();
        $vars = get_object_vars($foo);
    }
}

new fooone();

new bar();

new baz();

class footwo {
    public $bar;
    protected $baz;
    private $bas;    
//    public var1 = "Test"; // String видно опечатка в книге. Не может быть переменной без $
//    public var2 = '1.23'; // Numeric value
   
}

class foothree
{
    static function callerStat()
    {
        $m = __METHOD__; //foothree::callerStat в любом случае
    }

    public function callerNoStat()
    {
        $m =  __METHOD__; //foothree::callerNoStat в любом случае  
        $m = $this; //null до инициализации foothree object после
    }
}

foothree::callerNoStat(); // вообще не статический метод тоже вызвался.
foothree::callerStat();
$foot = new foothree();
$foot->callerNoStat(); //нормально
$foot->callerStat(); // нормально

$foo = new foostatic();
// Попробуем вызвать статический метод после инициализации класса
$foo->baz();
// 
//$stat0 = $foo::bar;// fatal
$stat = $foo->bar; // null 

class foostatic
{
    static $bar = 'bar';

    public static function baz()
    {
        echo __FUNCTION__;
        echo __METHOD__;
    }
}

//нельзя чтобы в двух разных интерфейсах были одинаковые методы, точнее 
//их нельзя имплементировать
interface testinheritance
{
    function method1();
    function method2();
}
class inheritone implements  testinheritance{
    public function method1(){
        echo __METHOD__;
    }
    public function method2(){
        echo __METHOD__;
    }
}
class inherittwo extends inheritone{
    public function method2(){
        echo __METHOD__;
    }
}

$f = new inherittwo();
$f->method2();

$z = new inheritone();
$z->method1();

/**
 * class Exception {
// The error message associated with this exception
protected $message = Unknown Exception;
// The error code associated with this exception
protected $code = 0;
// The pathname of the file where the exception occurred
protected $file;
// The line of the file where the exception occurred
protected $line;
// Constructor
function __construct ($message = null, $code = 0);
// Returns the message
final function getMessage();
// Returns the error code
final function getCode();
// Returns the file name
final function getFile();
// Returns the file line
final function getLine();
// Returns an execution backtrace as an array
final function getTrace();
// Returns a backtrace as a string
final function getTraceAsString();
// Returns a string representation of the exception
function __toString();
}

 */

// ловит все непойманные Ecxeption что позволяет избежать Fatal-а 
function catchAllUnhandledException($e)
{
    echo 'Last Exception!'.$e->getMessage();
}
// но для этого нужно назначить хендлер, кстати это будет последняя строка в коде
// кажется как то так
set_exception_handler('catchAllUnhandledException');

//throw new Exception ('Throw last exception');
//echo 'This code never execute! (i hope that all that write in this book, its naked truth';
// восстанавливает недавно определенный хендлер исключений
//Used after changing the exception handler function using set_exception_handler(), 
//to revert to the previous exception handler (which could be the built-in 
//or a user defined function). 
$st = restore_exception_handler();

function __autoload($class)
{
    require_once 'oop_files/Classes.php';
    if(class_exists($class)){
        $cl = new $class();
    }
    else{
        throw new Exception('exception');
    }
}
//Кастомный автозагрузчик
function __autoload_two($class)
{
    if(false){
        new $class();
    }
}

function __autoload_one($class)
{
    if(false){
        new $class();
    }
}

/**
 * Автозагрузчики регистрируются и потом выполняются в цепочке
 */
if(function_exists('__autoload_one')){
    spl_autoload_register('__autoload_one');
}

if(function_exists('__autoload_two')){
    spl_autoload_register('__autoload_two');
}

if(function_exists('__autoload')){
    spl_autoload_register('__autoload');
}

$cl = new Some_Class('some str');

//Reflection:

/**
 * Reflection test func
 * 
 * @param int $in
 * @return array
 */
function reflectionTestFunc($in){
    return array();
}

/**
 * Reflection class
 *
 * @author i am
 */
class reflectionTestClass{

    /**
     *  reflection
     *
     * @param int $test
     * @return int
     */
    public function test($test = '1')
    {
        return $test;
    }
    
    /**
     * Test method
     *
     * @param int $test_meta
     * @return int 
     */
    protected function metaProtected($test_meta = 2)
    {
        return $test_meta;
    }
    
    /**
     * Meta private
     *
     * @param int $test_meta
     */
    private function metaPrivate($test_meta = 3)
    {
        return 'rrr its cool!';
    }
}

// с рефлекцией тут нужно повнимательнее
try
{
    $many_functions = get_defined_functions();
    foreach ($many_functions['user'] as $func){ //фунцции делятся кстати на внутренние и user_defined
        $ref_func = new ReflectionFunction($func);
        $comment = $ref_func->getDocComment();
        $name = $ref_func->getName();
        $shortname = $ref_func->getShortName();
        $start_line = $ref_func->getStartLine();
        $ref = $ref_func->returnsReference();        
        $export = $ref_func->export($name); // экспорт ф-ции в строчку
        $is_defined = $ref_func->isUserDefined();
        $str = $ref_func->__toString();
        //$try_invoke = $ref_func->invoke();// ага при попытке вызова фатал
        //$try_invoke_too = $ref_func->invokeArgs(array('one'=>'one', 'two'=>'due'));
    }
    $refC = new ReflectionClass('reflectionTestClass'); // передаем имя подопытного класса

   $name_reflection_class = $refC->name; //reflectionTestClass
   $meth = $refC->getMethod('test'); //ReflectionMethod object
   $method = new ReflectionMethod('reflectionTestClass', 'metaPrivate');
   $method->setAccessible(true); //ничего кстати не возвращает
   $and_we_call_private = $method->invoke(new reflectionTestClass); // вернул rrr its cool!
                                //кстати вызов метода не совсем очевиден, нужно это запомнить
   
   
   /**
    * Reflection Method - документация
    * 
    *  Constants 
    * 
    const integer IS_STATIC = 1 ;
    const integer IS_PUBLIC = 256 ;
    const integer IS_PROTECTED = 512 ;
    const integer IS_PRIVATE = 1024 ;
    const integer IS_ABSTRACT = 2 ;
    const integer IS_FINAL = 4 ;
    Properties 
    public $ReflectionMethod->name ;
    public $class ;
    * 
    *  Methods 
    * 
    ReflectionMethod::__construct ( mixed $class , string $name )
    public static string ReflectionMethod::export ( string $class , string $name [, bool $return = false ] )
    public Closure ReflectionMethod::getClosure ( string $object )
    public ReflectionClass ReflectionMethod::getDeclaringClass ( void )
    public int ReflectionMethod::getModifiers ( void )
    public ReflectionMethod ReflectionMethod::getPrototype ( void )
    public mixed ReflectionMethod::invoke ( object $object [, mixed $parameter [, mixed $... ]] )
    public mixed ReflectionMethod::invokeArgs ( object $object , array $args )
    public bool ReflectionMethod::isAbstract ( void )
    public bool ReflectionMethod::isConstructor ( void )
    public bool ReflectionMethod::isDestructor ( void )
    public bool ReflectionMethod::isFinal ( void )
    public bool ReflectionMethod::isPrivate ( void )
    public bool ReflectionMethod::isProtected ( void )
    public bool ReflectionMethod::isPublic ( void )
    public bool ReflectionMethod::isStatic ( void )
    public void ReflectionMethod::setAccessible ( bool $accessible ) - Вот эта штука позволяет менять уровень 
    * видимости метода !!! Это просто офигенно. Пример ниже
    public string ReflectionMethod::__toString  
    * 
    * This is handy for accessing private methods but remember that things are normally private for a reason! Unit Testing is one (debatable) use case for this.

    Example:
    <?php
    class Foo {
      private function myPrivateMethod() {
        return 7;
      }
    }

    $method = new ReflectionMethod('Foo', 'myPrivateMethod');
    $method->setAccessible(true);

    echo $method->invoke(new Foo);
    // echos "7";

    Это очень офигенно работает с PHPUnit: http://php.net/manual/en/reflectionmethod.setaccessible.php
    * 
    */
   /**
    * Также из интересных возможностей рефлекции присутствует вот что
    * ReflectionClass::newInstanceWithoutConstructor ( void )
      Creates a new instance of the class without invoking the constructor. 
    */
   /**
    * Также интересный функционал у  Reflection Object
    * The ReflectionObject class reports information about an object.
    * Включает также полную инфу о классе, на базе которого создан. 
    * http://ua2.php.net/manual/en/class.reflectionobject.php
    */
   $methods = $refC->getMethods(); // коллекция ReflectionMethod object? причем в ней есть все методы включая 
                                    // protected и private
   $docComment = $refC->getDocComment(); // коммент
   $start = $refC->getStartLine(); // 483
   $end = $refC->getEndLine(); // 506

   $refF = new ReflectionFunction('reflectionTestFunc');
   $start = $refF->getStartLine();
   $end = $refF->getEndLine();

   foreach($refF->getParameters() as $param){
       $name_param = $param->getName();
       $by_reference = $param->isPassedByReference();
   }   
}
catch(ReflectionException $e)
{
    echo 'Reflection Exception:'.$e->getMessage();
}
