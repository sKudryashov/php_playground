<?php
echo "<h2> Functions </h2> ";
// ���� ���� ������� ������ �� ����������, php ���������� �� ���������� null
 $a = 1;
 error_reporting(E_ALL);
 $b= query();
 
 function &query ()  // ��� ���� ����������� PHP ������ notice, �.�. ���������� ����� ������ ���������� 
 { 	
 	return 'hallo';
 }
 
 // � ����� ���� ����� ������ = �.�. ������ ������ �� ������������
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
 // �������, � ����� ������ �������� ��� ������� ����������
 // ����� ��� ������ ��� ��������? ������ ��, ��� ��� � �������.
 
 $st = mysql_connect('localhost', 'root', '333888');
 mysql_select_db('luvshop');
 
 $sql = 'SELECT * FROM users';
 
 $handle = queryNew($sql);
 
 function &queryNew($sql)
{
    $result = mysql_query($sql);
    return $result; // ������ ����� ����� - ����� ���������� ������ �� ������, � �� ���������� ���
                    // ��� ����� ����� ������ �������� ������
}

 unset($b);
 unset($z);
 unset($c);
 
 function &query1($statement='')  
 {     // � ����� ������� ���: "�� ������ ������� ������ ���������� ��� resource �.�. ������ � php 
       // ������������ ����� ��������, � � ������ ������ - ������ - ����� ��������� ����������, 
       // � ������� query - ��� ���� - � ��������
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
 //$u = staticTest::$beta; ����������:) Fatal ������� ��
 staticTest(1); // ����������� ���������� ����� 2 
 staticTest(1); // ����������� ���������� ����� 3 
 staticTest(1); // ����������� ���������� ����� 4
 
 function staticTest ($a)
 {     
    static $beta; // ����������� ���������� �������� ��������� ��� ��� � ������ ���� �� ����
    if(!is_numeric($beta)){
         $beta = 0;
    }
    $beta += $a;
 }
 
 // �������� �������� �� ������ � �������- ���� � ��� ��� � 5.2.x � 5.3.x 
 // ��� ���� ����������
 
 $stuff= 1;
 //one(1); // ���. ���� �������� �� ������ � �� �������� 1 �� ����� �������� fatal
 one($stuff); ///����� $stuff = 2
 one($stuff); ///����� $stuff = 3
 one($stuff); ///����� $stuff = 4 - � ����� ��� ��� ���������
 
 
 $stuff_two = 5;
 two(&$stuff_two); //����� = 6
 two(&$stuff_two); // ����� = 7
 two(&$stuff_two); // ����� = 8 . ��� ��������� ������� - �� ��� ��� ������� 
                    // �������� �� ������ ����� �� ����������.
 
 function one(& $stuff)
 {
     $stuff++;
 }
 
 function two($stuff_two)
 {
     $stuff_two++;
 }
 
?>