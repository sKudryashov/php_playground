<?php
echo "<h2> Functions </h2> ";
// даже если функция ничего не возвращает, php принуждает ее возвращать null
 $a = 1;
 error_reporting(E_ALL);
 $b= query();
 
 function &query ()  // при этой конструкции PHP бросит notice, т.к. возвращать НУЖНО только переменные 
 { 	
 	return 'hallo';
 }
 
 // и здесь тоже будет нотайс = т.к. вообще ничего не возвращается
function &test()
{
    echo 'This is a test';
}

 
 $z = 'trulala';
 $b = query1(1);
 $c = query1(2);
 $z = 'storm';
 $b = 'tormoz';
 $c = 'asholl';
 $z = 'da dziga';
 // странно, а здесь вообще работают как обычные переменные
 // может это только для ресурсов? Вообще да, там так и пишется.
 
 $st = mysql_connect('localhost', 'root', '333888');
 mysql_select_db('luvshop');
 
 $sql = 'SELECT * FROM users';
 
 $handle = queryNew($sql);
 
 function &queryNew($sql)
{
    $result = mysql_query($sql);
    return $result; // короче смысл этого - чтобы передавать ссылку на ресурс, а не копировать его
                    // тем самым делая глупую ненужную работу
}

 unset($b);
 unset($z);
 unset($c);
 
 function &query1($statement='')  
 {     // в общем цитируя гид: "по ссылке функция обычно возвращает тип resource т.к. вообще в php 
       // возвращается копия значения, а в данном случае - ссылка - здесь нормально отработает, 
       // а функция query - что выше - с нотайсом
 	global $z;	
 	if($statement == 1)
 	{
 		$a += 5;
                $z = 'store';
 	}
 	else 
 	{
 		$z = 'just a test';
 	}
 	return $z;
 }
  
 $a = 5;
 
 $b = 8;
 
 tr($b);
 
 echo "<br> $a & $b";
 
 function tr (&$a)
 {
 	$a++;
 } 
 
 staticTest(1);
 //$u = staticTest::$beta; провокация:) Fatal конечно же
 staticTest(1); // статическая переменная равна 2 
 staticTest(1); // статическая переменная равна 3 
 staticTest(1); // статическая переменная равна 4
 
 function staticTest ($a)
 {     
    static $beta; // статическая переменная работает полностью так как и должно быть по идее
    if(!is_numeric($beta)){
         $beta = 0;
    }
    $beta += $a;
 }
 
 // проверим передачу по ссылке в функцию- дело в том что в 5.2.x и 5.3.x 
 // эти вещи отличаются
 
 $stuff= 1;
 //one(1); // ага. Если передача по ссылке и мы передаем 1 то здесь вылетает fatal
 one($stuff); ///здесь $stuff = 2
 one($stuff); ///здесь $stuff = 3
 one($stuff); ///здесь $stuff = 4 - в общем все как ожидалось
 
 
 $stuff_two = 5;
 two(&$stuff_two); //здесь = 6
 two(&$stuff_two); // здесь = 7
 two(&$stuff_two); // здесь = 8 . Что касатется функций - то эти два способа 
                    // передачи по ссылке ничем не отличаются.
 
 function one(& $stuff)
 {
     $stuff++;
 }
 
 function two($stuff_two)
 {
     $stuff_two++;
 }
 
?>