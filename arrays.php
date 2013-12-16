<?php

$a = array('b'=>'z','m'=>'sdsd');

$b = array('stomanissimo', 'sdsd'=>'1212');

$c = $a + $b;   //array(4) (
                //  [b] => (string) z
                //  [m] => (string) sdsd
                //  [0] => (string) stomanissimo
                //  [sdsd] => (string) 1212
                //)

$a = array('c'=>'one','b'=>'two'); 
$b = array ('c' =>'tree' , 'z' =>'four'); 

$stuff = 'onestuff';
$testlink_array = array('1'=>'1', '2'=>&$stuff);
$stuff = 'twostuff'; // ага. Передача по ссылке работает, теперь $testlink_array[2] = twostuff
//$testlink_array_key = array(&$stuff=>'2' , '0'=>'aa'); !а здесь сразу будет ошибка парсера
//то есть ключ не может передаваться по ссылке

$c = $b + $a ; // array(3) (
                //  [c] => (string) tree - получается что здесь остается старое значение из первого массива
                //  [z] => (string) four
                //  [b] => (string) two
                //)
$array = array('1'=>array('1'=>'stop'));
$array['1'][]['1'][] = 'tt'; // работает как нужно - получили
                            //array(1) (
                            //  [1] => array(2) (
                            //    [1] => (string) stop
                            //    [2] => array(1) (
                            //      [1] => array(1) (
                            //          array ( [0] => tt )
                            //      )
                            //    )
                            //  )
                            //)
//print_r($array);

// Сравнение массивов
$d = array('1', '2', '3');
$dd = array('2', '3', '1');
$a = array (1,3,2); 
$b = array (0=>1, 1=>2, 2=>3);
$c = array ('a'=>1, 'b'=>2, 'c'=>3);
$v = array ('a'=>1, 'b'=>2, 'c'=>3, 'z'=>'3');

// по книжке оператор == отдает true - если количество элементов и пары ключ=>значение
// одинаковые, даже если порядок разный. А оператор === отдает true только тогда, когда 
// и пары ключ значение и порядок идентичны. 
// Но на практике это не так. в любом случе отдает false
$res = ($dd == $d)? TRUE: FALSE; // должно быть true но реально false
$res = ($a == $b)? TRUE: FALSE; // false
$res = ($a === $b)? TRUE: FALSE; // false

$res = ($a == $c)? TRUE: FALSE; // false
$res = ($a === $c)? TRUE: FALSE; // false

$res = ($a == $d)? TRUE: FALSE; // должно быть true но реально false
$res = ($a === $d)? TRUE: FALSE; // false

$res = ($c > $v)? TRUE: FALSE; //fslse
$res = ($c < $v)? TRUE: FALSE; // true $v больше чем $c так как элементов больше

 $a = 10 ;
 $z = count ( $a ); // выдает 1 т.к. не может определить - массив ли ему задан или скаляр
 
 
 
 $a = $z =array('a' => NULL, 'b'=>1 );

 $c = isset($a['a']); // естестенно false 
  
 //а здесь true
 $c = array_key_exists('a',$a);
 
 unset($a['a']); // удаление элемента из массива
 
 // меняет местами ключи и значения в массиве 
$b = array_flip($z);  // а если в качестве значения NULL то кажется будет warning - да 
                    // так и есть - warning и еще говорит что флип можно делать только 
                    // строкам и integer числам - ну оно и понятно - только 
                    // строки и integer числа могут быть ключами
 
$z =  array('x'=>'a', 10=>'b',  'c'); 
$k = array_reverse($z);// меняет порядок следования членов массива 
                        //array(3) (
                        //  [0] => (string) c
                        //  [1] => (string) b
                        //  [x] => (string) a
                        //)


$arr = array('foo'=>'bar','baz','bat'=>2); 

while (key($arr) !== null){ // здесь лучше исп. оператор !== чтобы не напороться на 0
    $key = key($arr); // выдает ключ элемента, внутренний указатель массива стоит на 0 следовательно foo
    $current = current($arr); //bar
    $next = next($arr); //baz
    echo "<br> key $key current $current next $next"; 
}  
$reset = reset($arr); // перематывает указатель массива в начало
 
$arr = array('2','3','3','4');
foreach ($arr as $k => &$v)
{
	$v+=1;  // в итоге в массиве получим 3 4 4 5
} 



$arr = array('zero','one','two');
$arr2 = array('zero', 'one', 'twoo', 'three', 'four');
// пользоваться этим нужно очень осторолжно - объяснение ниже :
// странно а в итоге все равно array(3) (
        //  [0] => (string) zero
        //  [1] => (string) one
        //  [2] => (string) two)
foreach ($arr as $k=>&$v){
	

}
foreach ($arr2 as $k=>&$v) {
//	array(5) (
//  [0] => (string) zero
//  [1] => (string) one
//  [2] => (string) twoo
//  [3] => (string) three
//  [4] => (string) four
//) здесь тоже все норм
}
foreach ($arr as $k=>$v)
{
    //	а здесь так тем более все ок
    //    array(3) (
    //  [0] => (string) zero
    //  [1] => (string) one
    //  [2] => (string) two
    //)
} 

//!!!!!! в учебнике есть такое объяснение - но ситуацию мне воспроизвести не удалось
//может в моей версии этого и нет уже
// вроде бы невинная ситуация, но скрипт предлагает такой вывод: $arr =  array('zero','one','one'); 
// объяснение: как видно массив изменился и последний ключ имеет значение one вместо two.
//казалось бы баг - но нет, объяснение полностью логическое: первая итерация в массиве 
// не делает никаких изменений, как мы бы могли ожидать. Хотя это является причиной того
// что назначены ссылки на каждый из $arr элементов, следовательно каждое значение назначенное
// ему будет автоматически скопировано в последний элемент массива. Тогда во время 
// первой итерации $arr[2] станет 'zero' затем 'one' затем 'one' снова будет эффективно 
// скопирована сама в себя. Чтобы решить эту проблему - нужно всегда делать unset
// переменной, которую использую в передаче по ссылке в цикле foreach - а еще лучше 
// избегать использования "бывших в целом" 

 

// да sort уничтожает ключи конечно же, и перенумеровывают все эл-ты начиная с нуля
$array_ = $array__ = $array___ = array ('10t','3t','2t');
sort($array_); //10t 2t 3t
//sort и asort принимают 2 параметр который определяет - как проходит операция сортировки
// SORT_REGULAR - дефолт - сравнивает единицы, как они появляются в массиве 
//без представления любой конверсии
// SORT_NUMERIC конвертит каждый элемент в нумерованное значение для целей сортировки
sort($array__, SORT_NUMERIC); // сравнивает как цифры 2t 3t 10t
sort($array___, SORT_STRING); // сравнивает все элементы как строки 10t 2t 3t

$array = array ('10t','3t','2t');
// аsort сохраняет ассоциацию с ключами
asort($array); // 10t  2t 3 t // непонято почему так - по идее в обр порядке сорт
               // аа вот и объяснение - сравнение идет вот так: byte-by-byte
               // а поскольку 10t с этой точки зрения меньше чем 2t - потому что 
               // он стартует с символа 1 - то имеем то что имеем
               // вообще для правильного сравнения строк лучше использовать natsort
               // кстати он и ассоциации сохраняет по ключам



$arr = array ('10t','2t','3t');
natsort($arr);// natsort 2t 3t 10t 
//  natcasesort - case-insensitive вариант
$arr = $arr_ =  array('10T','10t','2t','3t');
natsort($arr_); // 2t 3t 10T 10t
natcasesort($arr); //2t 3t 10t 10T // вот у этой функции нет reverse sorting эквивалента

function myCmp($left,$right) 
{// первый вызов $left=2two $right=three второй $left=two $right=2two третий $left=one $right=2two хз 
//порядок какой
	$diff = strlen($left) - strlen($right);
	
	if(!$diff)
	{
		return strcmp($diff);
	}
	return $diff; // возврат или - 1 или 1 или 0 как я понял
}

$a = array('three','2two','one','two');

usort($a,'myCmp'); // указываем нашу функцию сортировки

var_dump($a); //array(4) (
                //  [0] => (string) two
                //  [1] => (string) one
                //  [2] => (string) 2two
                //  [3] => (string) three
                //)

$arr = array('keyq'=>'q','keya'=>'a','keyz'=>'z');
$zz = array_rand($arr,2); // 2  выталкивает 1 или больше ключей из массива рандомно
                            //array(2) (
                            //  [0] => (string) keyq
                            //  [1] => (string) keya
                            //)

// чтобы перемешать массив - можно также использовать функцию shuffle - но в этом случае 
// связи между ключами - значениями потеряются. 
$cards = array ('a' => 10, 'b' => 12, 'c' => 13);
$keys = array_keys($cards); // массив ключей выталкивает
shuffle($cards); //array(3) (
                //  [0] => (int) 13
                //  [1] => (int) 12
                //  [2] => (int) 10
                //)

$arr = array();

array_push($arr,'bar','baz','bb');

$as = array_pop($arr);

array_unshift($arr,'jjjjj');
$zzz = array_shift($arr);
$z = 1;
$a = array('1','3','2');
$b = array('1','3','4');

$x = array_diff($a,$b); // вернет 2  array([2] => (string) 2 )- т.е. с сохранением ключей

$a = array('1','4','3');
$b = array('1','3','4');

$x = array_diff($a,$b); // array(0)

$x1 = array_diff($a,$z); // $x1 = null и плюс еще warning

$a = array('1','4','3');
$b = array('1','3','4');
$x3 = array_diff($a, $b); // array(0)
// ?? ? ???? ??????? ????? ???????????? (??????, ?????????? ??????? ???? ???????? ??????? ?????????? ? ???? ???????? )
//   ???? ????? ???? ???? - ????????, ????? ???????????? : 
$arr1 = array('one'=>'1','two'=>'2','three'=>'3');
$arr2 = array('one'=>'1','four'=>'4','five'=>'5');

//Вычисляет разницу между массивами с дополнительной проверкой индекса
$ex1 = array_diff_assoc($arr1, $arr2); /* Array [2]	
	                                     two = (string:1) 2	
	                                     three = (string:1) 3	
                                       */
// Вычисляет разницу между массивами используя ключи для сравнения
$ex2 = array_diff_key($arr1, $arr2);  /* Array [2]	
	                                             two = (string:1) 2	
	                                             three = (string:1) 3 */
//Вычисляет разницу между массивами с доп проверкой индекса, которая представлена функцией коллбека, 
//предложенной пользователем    
//TODO: отработать - посмотреть как функция коллбека работает
$ex3 = array_diff_uassoc($arr1, $arr2, 'uasscomp'); /*"$ex3" = Array [2] 	
	                                                   two = (string:1) 2	
	                                                   three = (string:1) 3	*/

// Вычисляет разницу между массивами используя ключи для сравнения через функцию коллбека  
//TODO: отработать - посмотреть как функция коллбека работает
$ex4 = array_diff_ukey($arr1, $arr2, 'ukeycomp');   /*"$ex3" = Array [2] 
	                                                   two = (string:1) 2	
	                                                   three = (string:1) 3	
                                                     */
$a = array('1','4','3');
$b = array('1','3','4');
$int = array_intersect($a, $b); // выявляет пересечение массивов
                                 /* "$int" = Array [3]	
	                                  0 = (string:1) 1	
	                                  1 = (string:1) 4	
	                                  2 = (string:1) 3	
                                  */
//функции коллбека
function uasscomp($one, $two)
{
	if($one > $two)
	{
		return 1;
	}  
	if ($one < $two)
	{
		return -1;
	}  
} 
function ukeycomp ($one, $two) 
{
	if($one > $two)
	{
		return 1;
	}  
	if ($one < $two)
	{
		return -1;
	}  
	
} 
