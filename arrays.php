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
$stuff = 'twostuff'; // ���. �������� �� ������ ��������, ������ $testlink_array[2] = twostuff
//$testlink_array_key = array(&$stuff=>'2' , '0'=>'aa'); !� ����� ����� ����� ������ �������
//�� ���� ���� �� ����� ������������ �� ������

$c = $b + $a ; // array(3) (
                //  [c] => (string) tree - ���������� ��� ����� �������� ������ �������� �� ������� �������
                //  [z] => (string) four
                //  [b] => (string) two
                //)
$array = array('1'=>array('1'=>'stop'));
$array['1'][]['1'][] = 'tt'; // �������� ��� ����� - ��������
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

// ��������� ��������
$d = array('1', '2', '3');
$dd = array('2', '3', '1');
$a = array (1,3,2); 
$b = array (0=>1, 1=>2, 2=>3);
$c = array ('a'=>1, 'b'=>2, 'c'=>3);
$v = array ('a'=>1, 'b'=>2, 'c'=>3, 'z'=>'3');

// �� ������ �������� == ������ true - ���� ���������� ��������� � ���� ����=>��������
// ����������, ���� ���� ������� ������. � �������� === ������ true ������ �����, ����� 
// � ���� ���� �������� � ������� ���������. 
// �� �� �������� ��� �� ���. � ����� ����� ������ false
$res = ($dd == $d)? TRUE: FALSE; // ������ ���� true �� ������� false
$res = ($a == $b)? TRUE: FALSE; // false
$res = ($a === $b)? TRUE: FALSE; // false

$res = ($a == $c)? TRUE: FALSE; // false
$res = ($a === $c)? TRUE: FALSE; // false

$res = ($a == $d)? TRUE: FALSE; // ������ ���� true �� ������� false
$res = ($a === $d)? TRUE: FALSE; // false

$res = ($c > $v)? TRUE: FALSE; //fslse
$res = ($c < $v)? TRUE: FALSE; // true $v ������ ��� $c ��� ��� ��������� ������

 $a = 10 ;
 $z = count ( $a ); // ������ 1 �.�. �� ����� ���������� - ������ �� ��� ����� ��� ������
 
 
 
 $a = $z =array('a' => NULL, 'b'=>1 );

 $c = isset($a['a']); // ���������� false 
  
 //� ����� true
 $c = array_key_exists('a',$a);
 
 unset($a['a']); // �������� �������� �� �������
 
 // ������ ������� ����� � �������� � ������� 
$b = array_flip($z);  // � ���� � �������� �������� NULL �� ������� ����� warning - �� 
                    // ��� � ���� - warning � ��� ������� ��� ���� ����� ������ ������ 
                    // ������� � integer ������ - �� ��� � ������� - ������ 
                    // ������ � integer ����� ����� ���� �������
 
$z =  array('x'=>'a', 10=>'b',  'c'); 
$k = array_reverse($z);// ������ ������� ���������� ������ ������� 
                        //array(3) (
                        //  [0] => (string) c
                        //  [1] => (string) b
                        //  [x] => (string) a
                        //)


$arr = array('foo'=>'bar','baz','bat'=>2); 

while (key($arr) !== null){ // ����� ����� ���. �������� !== ����� �� ���������� �� 0
    $key = key($arr); // ������ ���� ��������, ���������� ��������� ������� ����� �� 0 ������������� foo
    $current = current($arr); //bar
    $next = next($arr); //baz
    echo "<br> key $key current $current next $next"; 
}  
$reset = reset($arr); // ������������ ��������� ������� � ������
 
$arr = array('2','3','3','4');
foreach ($arr as $k => &$v)
{
	$v+=1;  // � ����� � ������� ������� 3 4 4 5
} 



$arr = array('zero','one','two');
$arr2 = array('zero', 'one', 'twoo', 'three', 'four');
// ������������ ���� ����� ����� ���������� - ���������� ���� :
// ������� � � ����� ��� ����� array(3) (
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
//) ����� ���� ��� ����
}
foreach ($arr as $k=>$v)
{
    //	� ����� ��� ��� ����� ��� ��
    //    array(3) (
    //  [0] => (string) zero
    //  [1] => (string) one
    //  [2] => (string) two
    //)
} 

//!!!!!! � �������� ���� ����� ���������� - �� �������� ��� ������������� �� �������
//����� � ���� ������ ����� � ��� ���
// ����� �� �������� ��������, �� ������ ���������� ����� �����: $arr =  array('zero','one','one'); 
// ����������: ��� ����� ������ ��������� � ��������� ���� ����� �������� one ������ two.
//�������� �� ��� - �� ���, ���������� ��������� ����������: ������ �������� � ������� 
// �� ������ ������� ���������, ��� �� �� ����� �������. ���� ��� �������� �������� ����
// ��� ��������� ������ �� ������ �� $arr ���������, ������������� ������ �������� �����������
// ��� ����� ������������� ����������� � ��������� ������� �������. ����� �� ����� 
// ������ �������� $arr[2] ������ 'zero' ����� 'one' ����� 'one' ����� ����� ���������� 
// ����������� ���� � ����. ����� ������ ��� �������� - ����� ������ ������ unset
// ����������, ������� ��������� � �������� �� ������ � ����� foreach - � ��� ����� 
// �������� ������������� "������ � �����" 

 

// �� sort ���������� ����� ������� ��, � ���������������� ��� ��-�� ������� � ����
$array_ = $array__ = $array___ = array ('10t','3t','2t');
sort($array_); //10t 2t 3t
//sort � asort ��������� 2 �������� ������� ���������� - ��� �������� �������� ����������
// SORT_REGULAR - ������ - ���������� �������, ��� ��� ���������� � ������� 
//��� ������������� ����� ���������
// SORT_NUMERIC ��������� ������ ������� � ������������ �������� ��� ����� ����������
sort($array__, SORT_NUMERIC); // ���������� ��� ����� 2t 3t 10t
sort($array___, SORT_STRING); // ���������� ��� �������� ��� ������ 10t 2t 3t

$array = array ('10t','3t','2t');
// �sort ��������� ���������� � �������
asort($array); // 10t  2t 3 t // �������� ������ ��� - �� ���� � ��� ������� ����
               // �� ��� � ���������� - ��������� ���� ��� ���: byte-by-byte
               // � ��������� 10t � ���� ����� ������ ������ ��� 2t - ������ ��� 
               // �� �������� � ������� 1 - �� ����� �� ��� �����
               // ������ ��� ����������� ��������� ����� ����� ������������ natsort
               // ������ �� � ���������� ��������� �� ������



$arr = array ('10t','2t','3t');
natsort($arr);// natsort 2t 3t 10t 
//  natcasesort - case-insensitive �������
$arr = $arr_ =  array('10T','10t','2t','3t');
natsort($arr_); // 2t 3t 10T 10t
natcasesort($arr); //2t 3t 10t 10T // ��� � ���� ������� ��� reverse sorting �����������

function myCmp($left,$right) 
{// ������ ����� $left=2two $right=three ������ $left=two $right=2two ������ $left=one $right=2two �� 
//������� �����
	$diff = strlen($left) - strlen($right);
	
	if(!$diff)
	{
		return strcmp($diff);
	}
	return $diff; // ������� ��� - 1 ��� 1 ��� 0 ��� � �����
}

$a = array('three','2two','one','two');

usort($a,'myCmp'); // ��������� ���� ������� ����������

var_dump($a); //array(4) (
                //  [0] => (string) two
                //  [1] => (string) one
                //  [2] => (string) 2two
                //  [3] => (string) three
                //)

$arr = array('keyq'=>'q','keya'=>'a','keyz'=>'z');
$zz = array_rand($arr,2); // 2  ����������� 1 ��� ������ ������ �� ������� ��������
                            //array(2) (
                            //  [0] => (string) keyq
                            //  [1] => (string) keya
                            //)

// ����� ���������� ������ - ����� ����� ������������ ������� shuffle - �� � ���� ������ 
// ����� ����� ������� - ���������� ����������. 
$cards = array ('a' => 10, 'b' => 12, 'c' => 13);
$keys = array_keys($cards); // ������ ������ �����������
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

$x = array_diff($a,$b); // ������ 2  array([2] => (string) 2 )- �.�. � ����������� ������

$a = array('1','4','3');
$b = array('1','3','4');

$x = array_diff($a,$b); // array(0)

$x1 = array_diff($a,$z); // $x1 = null � ���� ��� warning

$a = array('1','4','3');
$b = array('1','3','4');
$x3 = array_diff($a, $b); // array(0)
// ?? ? ???? ??????? ????? ???????????? (??????, ?????????? ??????? ???? ???????? ??????? ?????????? ? ???? ???????? )
//   ???? ????? ???? ???? - ????????, ????? ???????????? : 
$arr1 = array('one'=>'1','two'=>'2','three'=>'3');
$arr2 = array('one'=>'1','four'=>'4','five'=>'5');

//��������� ������� ����� ��������� � �������������� ��������� �������
$ex1 = array_diff_assoc($arr1, $arr2); /* Array [2]	
	                                     two = (string:1) 2	
	                                     three = (string:1) 3	
                                       */
// ��������� ������� ����� ��������� ��������� ����� ��� ���������
$ex2 = array_diff_key($arr1, $arr2);  /* Array [2]	
	                                             two = (string:1) 2	
	                                             three = (string:1) 3 */
//��������� ������� ����� ��������� � ��� ��������� �������, ������� ������������ �������� ��������, 
//������������ �������������    
//TODO: ���������� - ���������� ��� ������� �������� ��������
$ex3 = array_diff_uassoc($arr1, $arr2, 'uasscomp'); /*"$ex3" = Array [2] 	
	                                                   two = (string:1) 2	
	                                                   three = (string:1) 3	*/

// ��������� ������� ����� ��������� ��������� ����� ��� ��������� ����� ������� ��������  
//TODO: ���������� - ���������� ��� ������� �������� ��������
$ex4 = array_diff_ukey($arr1, $arr2, 'ukeycomp');   /*"$ex3" = Array [2] 
	                                                   two = (string:1) 2	
	                                                   three = (string:1) 3	
                                                     */
$a = array('1','4','3');
$b = array('1','3','4');
$int = array_intersect($a, $b); // �������� ����������� ��������
                                 /* "$int" = Array [3]	
	                                  0 = (string:1) 1	
	                                  1 = (string:1) 4	
	                                  2 = (string:1) 3	
                                  */
//������� ��������
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
