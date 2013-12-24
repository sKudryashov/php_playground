<?php
/**
 * odesk polygon
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
echo !0;

$a = 0x01; //1
$b = 0x02; //2
echo "$a\n";
echo "$b\n";
echo $b<<$a."\n"; //4
echo $a === $b<<$a; // 0
die();


$foo = 5+"10 things";
echo $foo; die();

$a = 5;
// валидный
if($a==5):
    echo 'hello';
    echo 3;
else:
    echo 'not hello';
    echo 23;
endif;

//if($a>15 or <7) PARSE ERRROR
//    echo true; 
//else
//    echo false;
// md5 32 символа sha1 -

//$d = 1 . 3; //13
//$s = 3*print(3); //3
//$r = (3* print(3)); //3
//$f = (2) . 3;
echo (2).(3*print(3));

$a = (1<<0);
$b = (1<<1);
$ss = 1<<1;
$rr4 = ($b|$a); //3
$rr = ($b|$a)<<2; //12
$ree = 3<<2; //12

$s = 0x500; //1280

$z = 5*6/2 + 2*3; //21

$z = 'sprintf';
$ds = $z('go negr'); // работает

$a = "echo";
$b = $a('echlo'); // Fatal

$a = "print";
$b = $a('echlo'); // Fatal

$str = "Hello world";
$s = $str[4]; // о


setlocale(LC_ALL, "fr_FR");
$st = (string) 3.5;
$st = (float) 3.5; //3.5 

$t = is_numeric("200"); // true
$t = is_numeric("200,0"); //false
$t = is_numeric("$200"); //false
$t = is_numeric(".25e4"); //true
$a = ".25e4";
$b = $a+1; //2501
$c = "200,9" + 1; //201 (о как!)
$c2 = "200jhh"+1; //201
$c3 = "jsks31"+1; //1

$a = 0500; //320

$a = "5.0"=="5"; //true

$a = "Hello";
if(md5($a)===md5($a)){
    $z = true; //true
}else{
    $z = false;
}



$a = (1<<0);
$b = (1<<1);
$c = $b|$a;


$st = array();
$t2 = 0;
$is_st = empty($st); // true
$is_t2 = empty($t2); // true

$a = 'abooo \n';
$is = (bool) "FALSE";
$is = (bool) "0";
$is = (bool) null;
$a = 30*5 . 7;
$company = 'ABS Ltd';
$$company = ', Sidney';
// what is the incorrect way of printing "ABS ltd, Sidney"
$r = "$company $$company";
$r = "$company ${$company}";
$r = "$company ${'ABS Ltd'}";
$r = "$company {$$company}";

$i = 6;
while($i > 4):
    $i--;
    endwhile;
    
    while($i > 0) $i--;

abstract class testAbstract{
    // abstract function testMemo(){} конечно же такое объявление нелегально. - у абстрактного метода нет тела
}
class testClass extends testAbstract{
//    function __construct(){
//        $m = __METHOD__;
//    }
    function testClass(){
        $m = __METHOD__;
        
        $this->super();
    }    
    //abstract function testMemo(); конечно же класс содержащий абстрактный метод должен быть и сам абстрактным
    
    private function checkMe(){
        echo 'checkMe';
    }
        
    function __call($method, $data){ // такое объявление - Warning вылетает хотя метод отрабатывает
        $m = $method;
    }
}

$cl = new testClass();
$cl->checkMe();


$a = array('one'=>1, 'two'=>2); 
$b = array('two'=>'2-1', 'three'=>3);
$x = $a+$b;
$var = 10;
$b = 4<<5; //128

function st (){
    $var = 20;
    return $var;
}
st();
$vars = $var; 

$st = sha1('88383');
$strlen = strlen($st); // sha1 - 40 символов
$st = crc32('88383');
$strlen = strlen($st); //10

$bodytag = str_replace("%body%", "black", "<body text='%body%'>"); //<body text='black'>

$bodytag = str_replace(array('b', 'd', 'y'), 
        array('y', 'a', 'b'), 
        "<body text='%body%'>"); //<boab text='%boab%'>

$bodytag = str_replace('%body%', true, "<body text='%body%'>"); //<body text='1'> boolean автоматом конверт в 1

$bodytag = str_replace('%body%', 1, "<body text='%body%'>"); //) <body text='1'>


static $varb = array(1, 'varb', 3);
//static $varb = 1+(2*90); //неправильное объявление
//static $varb = sqrt(81); //неправильное объявление
//static $varb = new Object(); //неправильное объявление



//проверка - могут ли разные интерфейсы с одинаковыми методами и аргументами быть 
//имплементированы в одном классе 
interface iOne{
    function first ($one, $two);
    
    function second (&$one, $two);    
}

interface iTwo{
    function second (&$one, $two);
    
    function third($one, $two);
}

interface iThree {
    function fourth();
}

interface iFour extends iOne, iThree{
//abstract function iSmart(); // выдает вот что: Fatal error: Access type for interface method iFour::iSmart() must be omitted
    function iSmart();
}

// само собой что класс должен имплементировать все методы, которые расширяет
// интерфейс iFour и 
class testMultipleExtendingInterfaces implements iFour{
    function iSmart(){
        return 1;
    }
    
    public function fourth(){}


    public function first ($one, $two){
         return $one+$two;
     }
    
   public function second (&$one, $two){ // совместимое объявление включает в себя и опции передачи по ссылке также
        return $one+$two;
    }
}

$five = 5;
$st = new testMultipleExtendingInterfaces();
$r = $st->iSmart();
$r2 = $st->first(2,2);
$r3 = $st->second($five, 2);


// ага - здесь даже ошибка парсера. То есть интерфейс не может имплементировать
// другие интерфейсы - только расширять
//interface iFive implements iOne, iTwo{
//    function iSmart();
//}

// ага. Нельзя имплементировать интерфейсы с двумя одинаковыми методами, даже если они полностью
// идентичны: Fatal error: Can't inherit abstract function iTwo::second() (previously declared abstract in iOne)
//class weWillTestSame implements iOne, iTwo{
//    public function first ($one, $two){
//        return $one+$two;
//    }
//    
//    public function second($one, $two){
//        return $one+$two;
//    }
//}



//$s = new weWillTestSame();
//$a = $s->first('w', 'q');
//$b = $s->second('e', 'b');
//
//$s = new weWillTestNotSame();
//$a = $s->second(2);
//$x = $s->fourth();

function &a(&$a)
{
    if($a){
        return $a;
    }    
}
$a = 10;
$v = &a($a);
$v++; // и a == v == 11

$q = a($a);
$q++; //q = 12 a = 11
$zz;
dotOne(4);
function dotOne($n){
    global $zz;
    if($n>0){
        dotOne(--$n); // особенности вызова рекурсии в php. После выхода из функции 
                        // помним что интерпретатор вернется в нее и пройдет оставшиеся операторы
                        // ДО КОТОРЫХ РЕКУРСИЯ НЕ ДОШЛА
        
        $zz .= '.';
    }
    else{
        $zz .= '0';
    }
}
$arr = array(0.001=>'uno', .1=>'due'); // ебанутый немного язык... array(1) (  [0] => (string) due)

$a = 010; //$a = 8 - восьмеричная система, прведение к десятичной
$b = 0xA; //$b = 10 - 16ричная система, приведение к десятичной
$c = 2;
print $a + $b + $c;

$current = $string[$i];
$count = 1;
while (isset($string[$i+$count]) && $string[$i+$count] == $current) $current++;
$newstring .= "$count{$current}";
$i +=$count-1;

$a = $newstring;
//29 вопрос битый какой то.
?>

