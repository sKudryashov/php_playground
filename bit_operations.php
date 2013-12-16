<?php

//�� ����������� ����� ������ ����� ��� �� 32 ���� �� 32-������ ��������. 
//�� ����������� ����� ����� ��� ��������� �����, ��������� ��� ������ ����� 32 ���.
//����������� ������� �� ���������� gmp ��� ��������� �������� ��� �������, �������� 
//��� PHP_INT_MAX.

/**
 * bit_operations  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 * 
 * 
 * --- ����� ������ ��� �������������� ������ ������� ---
���������: 2 = 4 >> 1
 ���������� ���:
  val=4
  res=2
 �������� ���:
  val=00000000000000000000000000000100
  res=00000000000000000000000000000010
 ���������: ����� ���� ��������� ����� ��������� ���� 

���������: 1 = 4 >> 2
 ���������� ���:
  val=4
  res=1
 �������� ���:
  val=00000000000000000000000000000100
  res=00000000000000000000000000000001

���������: 0 = 4 >> 3
 ���������� ���:
  val=4
  res=0
 �������� ���:
  val=00000000000000000000000000000100
  res=00000000000000000000000000000000
 ���������: ���� ���� ��������� �� ������ ����

���������: 0 = 4 >> 4
 ���������� ���:
  val=4
  res=0
 �������� ���:
  val=00000000000000000000000000000100
  res=00000000000000000000000000000000
 ���������: �� ��, ��� � ����; ������ �������� ������ 0


--- ����� ������ �� ������������� ����� ������ ---
���������: -2 = -4 >> 1
 ���������� ���:
  val=-4
  res=-2
 �������� ���:
  val=11111111111111111111111111111100
  res=11111111111111111111111111111110
 ���������: ����� ���� ��������� ����� ��������� ����

���������: -1 = -4 >> 2
 ���������� ���:
  val=-4
  res=-1
 �������� ���:
  val=11111111111111111111111111111100
  res=11111111111111111111111111111111
 ���������: ���� ���� ��������� �� ������ ����

���������: -1 = -4 >> 3
 ���������� ���:
  val=-4
  res=-1
 �������� ���:
  val=11111111111111111111111111111100
  res=11111111111111111111111111111111
 ���������: �� ��, ��� � ����; ������ �������� ������ -1


--- ����� ����� ��� �������������� ������ ������� ---
���������: 8 = 4 << 1
 ���������� ���:
  val=4
  res=8
 �������� ���:
  val=00000000000000000000000000000100
  res=00000000000000000000000000001000
 ���������: ������ ���� ��� �������� ������

���������: 1073741824 = 4 << 28
 ���������� ���:
  val=4
  res=1073741824
 �������� ���:
  val=00000000000000000000000000000100
  res=01000000000000000000000000000000

���������: -2147483648 = 4 << 29
 ���������� ���:
  val=4
  res=-2147483648
 �������� ���:
  val=00000000000000000000000000000100
  res=10000000000000000000000000000000
 ���������: �������� ���� ���� ���������

���������: 0 = 4 << 30
 ���������� ���:
  val=4
  res=0
 �������� ���:
  val=00000000000000000000000000000100
  res=00000000000000000000000000000000
 ���������: ���� ���� ��������� �� ����� ����


--- ����� ����� ��� �������������� ������ ������� ---
���������: -8 = -4 << 1
 ���������� ���:
  val=-4
  res=-8
 �������� ���:
  val=11111111111111111111111111111100
  res=11111111111111111111111111111000
 ���������: ������ ���� ��� �������� ������

���������: -2147483648 = -4 << 29
 ���������� ���:
  val=-4
  res=-2147483648
 �������� ���:
  val=11111111111111111111111111111100
  res=10000000000000000000000000000000

���������: 0 = -4 << 30
 ���������� ���:
  val=-4
  res=0
 �������� ���:
  val=11111111111111111111111111111100
  res=00000000000000000000000000000000
 ���������: ���� ���� ��������� �� ����� ����, ������� �������� ���

��������� ���������� ������� ������� �� 64-������ �������:

--- ����� ������ ��� �������������� ������ ������� ---
���������: 2 = 4 >> 1
 ���������� ���:
  val=4
  res=2
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0000000000000000000000000000000000000000000000000000000000000010
 ���������: ����� ���� ��������� ����� ��������� ����

���������: 1 = 4 >> 2
 ���������� ���:
  val=4
  res=1
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0000000000000000000000000000000000000000000000000000000000000001

���������: 0 = 4 >> 3
 ���������� ���:
  val=4
  res=0
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0000000000000000000000000000000000000000000000000000000000000000
 ���������: ���� ���� ��������� �� ������ ����

���������: 0 = 4 >> 4
 ���������� ���:
  val=4
  res=0
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0000000000000000000000000000000000000000000000000000000000000000
 ���������: �� ��, ��� � ����; ������ �������� ������ 0


--- ����� ������ ��� �������������� ������ ������� ---
���������: -2 = -4 >> 1
 ���������� ���:
  val=-4
  res=-2
 �������� ���:
  val=1111111111111111111111111111111111111111111111111111111111111100
  res=1111111111111111111111111111111111111111111111111111111111111110
 ���������: ����� ���� ��������� ����� ��������� ����

���������: -1 = -4 >> 2
 ���������� ���:
  val=-4
  res=-1
 �������� ���:
  val=1111111111111111111111111111111111111111111111111111111111111100
  res=1111111111111111111111111111111111111111111111111111111111111111
 ���������: ���� ���� ��������� �� ������ ����

���������: -1 = -4 >> 3
 ���������� ���:
  val=-4
  res=-1
 �������� ���:
  val=1111111111111111111111111111111111111111111111111111111111111100
  res=1111111111111111111111111111111111111111111111111111111111111111
 ���������: �� ��, ��� � ����; ������ �������� ������ -1


--- ����� ����� ��� �������������� ������ ������� ---
���������: 8 = 4 << 1
 ���������� ���:
  val=4
  res=8
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0000000000000000000000000000000000000000000000000000000000001000
 ���������: ������ ���� ��� �������� ������

���������: 4611686018427387904 = 4 << 60
 ���������� ���:
  val=4
  res=4611686018427387904
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0100000000000000000000000000000000000000000000000000000000000000

���������: -9223372036854775808 = 4 << 61
 ���������� ���:
  val=4
  res=-9223372036854775808
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=1000000000000000000000000000000000000000000000000000000000000000
 ���������: �������� ���� ���� ���������

���������: 0 = 4 << 62
 ���������� ���:
  val=4
  res=0
 �������� ���:
  val=0000000000000000000000000000000000000000000000000000000000000100
  res=0000000000000000000000000000000000000000000000000000000000000000
 ���������: ���� ���� ��������� �� ����� ����


--- ����� ����� ��� �������������� ������ ������� ---
���������: -8 = -4 << 1
 ���������� ���:
  val=-4
  res=-8
 �������� ���:
  val=1111111111111111111111111111111111111111111111111111111111111100
  res=1111111111111111111111111111111111111111111111111111111111111000
 ���������: ������ ���� ��� �������� ������

���������: -9223372036854775808 = -4 << 61
 ���������� ���:
  val=-4
  res=-9223372036854775808
 �������� ���:
  val=1111111111111111111111111111111111111111111111111111111111111100
  res=1000000000000000000000000000000000000000000000000000000000000000

���������: 0 = -4 << 62
 ���������� ���:
  val=-4
  res=0
 �������� ���:
  val=1111111111111111111111111111111111111111111111111111111111111100
  res=0000000000000000000000000000000000000000000000000000000000000000
 ���������: ���� ���� ��������� �� ����� ����, ������� �������� ���


 */

/**
 * ��� ���� ��������� �������� � php
 */
//$a & $b 	� 	��������������� ������ �� ����, ������� ����������� � � $a, � � $b.
//$a | $b 	��� 	��������������� �� ����, ������� ����������� � $a ��� � $b.
//$a ^ $b 	����������� ��� 	��������������� ������ �� ����, ������� ����������� 
//���� ������ � $a, ���� ������ � $b, �� �� � ����� ������������.
//~ $a 	��������� 	��������������� �� ����, ������� �� ����������� � $a, � ��������.
//$a << $b 	����� ����� 	��� ���� ���������� $a ���������� �� $b ������� ����� 
//(������ ������� ������������� "��������� �� 2")
//$a >> $b 	����� ������ 	��� ���� ���������� $a ���������� �� $b ������� ������ 
//(������ ������� ������������� "������� �� 2")

/*
 * ��������� ��������.
 */
$val = 4; //00000000000000000000000000000100
$places = '';
$res = ~$val;// -5 �.� 11111111111111111111111111111011
p($res, $val, '~', $places, '~ - ���������', $res);


//��������� ����������� ��� (��� ��������� �������� �� ������ ���) � ��� �������� ��������, 
//�������� ������� ������������ ���������� ����������� ������������ ��� � ������ ���� �����,
//������� ����� �� ���������� �������� � �������� �������������� ���������. 
//������� �������, ���� ��������������� ���� ��������� ��������, �� �������� ������ 
//���������� ����� 1; ���� �� ���� ���������, �� �������� ������ ���������� ����� 0.
//
//������:
//����. ��� 	0011
//              0101
//���������     0110
$val = 4; //00000000000000000000000000000100
$places = 2;
$res = $val ^ $places; // 6 �.�. 00000000000000000000000000000110
p($res, $val, '^', $places, '^ - xor(����������� ���)', $res);


//��������� ��� (OR)
//��������� ��� � ��� �������� ��������, �������� ������� ������������ ���������� 
//����������� ��� � ������ ���� �����, ������� ����� �� ���������� �������� � 
//�������� �������������� ���������. ������� �������, ���� ��� ��������������� ���� 
//��������� ����� 0, �������� ������ ���������� ����� 0; ���� �� ���� �� ���� ��� ��
//���� ����� 1, �������� ������ ���������� ����� 1.
//
//������:
//���        0011
//           0101
//���������  0111
$val = 4; //00000000000000000000000000000100
$places = 2;
$res = $val | $places; // 6 �.�. 00000000000000000000000000000110
p($res, $val, '|', $places, '| - or(���)', $res);


//��������� � (AND)
//
//��������� � � ��� �������� ��������, �������� ������� ������������ ���������� ����������� 
//� � ������ ���� �����, ������� ����� �� ���������� �������� � �������� �������������� ���������. 
//������� �������, ���� ��� ��������������� ���� ��������� ����� 1, �������������� �������� ������ 
//����� 1; ���� �� ���� �� ���� ��� �� ���� ����� 0, �������������� �������� ������ ����� 0.
//
//������:
//�         0011
//          0101
//��������� 0001
$val = 4; //00000000000000000000000000000100
$places = 2;
$res = $val & $places; // 0 �.�. 00000000000000000000000000000000
p($res, $val, '&', $places, '& - and(�)', $res);

echo "\n--- ����� ������ ��� �������������� ������ ������� ---\n";

$val = 4;
$places = 1;
$res = $val >> $places; // ������ ��. �����������. 4/2n
p($res, $val, '>>', $places, '����� ���� ��������� ����� ��������� ����', $res);

$val = 4;
$places = 2;
$res = $val >> $places; //1 ������ ������� 4/2n
p($res, $val, '>>', $places);

$val = 4;
$places = 3;
$res = $val >> $places; // 0 �.�. 4/2n � ����� ������������� �������
p($res, $val, '>>', $places, '���� ���� ��������� �� ������ ����');

$val = 4;
$places = 4;
$res = $val >> $places;
p($res, $val, '>>', $places, '�� ��, ��� � ����; ������ �������� ������ 0');


$val = 4;
$places = 4;
$res = $val >> $places;
p($res, $val, '>>', $places, '�� ��, ��� � ����; ������ �������� ������ 0');

echo "\n--- ����� ������ ��� �������������� ������ ������� ---\n";

$val = -4; //11111111111111111111111111111100
$places = 1;
$res = $val >> $places; //-2 �.�. 11111111111111111111111111111110
p($res, $val, '>>', $places, '����� ���� ��������� ����� ��������� ����');

$val = -4; //11111111111111111111111111111100
$places = 2;
$res = $val >> $places; //-1 �.�. 11111111111111111111111111111111
p($res, $val, '>>', $places, '���� ���� ��������� �� ������ ����');

$val = -4; //11111111111111111111111111111100
$places = 3;
$res = $val >> $places; //-1 �.�. 11111111111111111111111111111111
p($res, $val, '>>', $places, '�� ��, ��� � ����; ������ �������� ������ -1');


echo "\n--- ����� ����� ��� �������������� ������ ������� ---\n";

$val = 4; //00000000000000000000000000000100
$places = 1;
$res = $val << $places;//8 �.�. * 2n �.�. 00000000000000000000000000001000
p($res, $val, '<<', $places, '������ ���� ��� �������� ������');

$val = 4; //00000000000000000000000000000100
$places = (PHP_INT_SIZE * 8) - 4; //28
$res = $val << $places; //1073741824 �.�. 01000000000000000000000000000000
p($res, $val, '<<', $places);

$val = 4; //00000000000000000000000000000100
$places = (PHP_INT_SIZE * 8) - 3; //29
$res = $val << $places; //-2147483648 �.�. 10000000000000000000000000000000
p($res, $val, '<<', $places, '�������� ���� ���� ���������');

$val = 4; //00000000000000000000000000000100
$places = (PHP_INT_SIZE * 8) - 2; //30
$res = $val << $places; //0 �.�. 00000000000000000000000000000000
p($res, $val, '<<', $places, '���� ���� ��������� �� ����� ����');


echo "\n--- ����� ����� ��� �������������� ������ ������� ---\n";

$val = -4; //11111111111111111111111111111100
$places = 1;
$res = $val << $places;//-8 �.�. 11111111111111111111111111111000
p($res, $val, '<<', $places, '������ ���� ��� �������� ������');

$val = -4; //11111111111111111111111111111100
$places = (PHP_INT_SIZE * 8) - 3; //29
$res = $val << $places; //-2147483648  10000000000000000000000000000000
p($res, $val, '<<', $places);

$val = -4; //11111111111111111111111111111100
$places = (PHP_INT_SIZE * 8) - 2; //30
$res = $val << $places; //0 00000000000000000000000000000000
p($res, $val, '<<', $places, '���� ���� ��������� �� ����� ����, ������� �������� ���');


/*
 * �� ��������� �������� �� ���� ������ ������ ����,
 * ��� ������ �������������� ��� ����� ������ ������.
 */

function p($res, $val, $op, $places, $note = '', $shift) {
        
    $format= '�� %2$s ����� %1$32d �������';
    $ff =  sprintf($format, 5, '������'); // �� ������ �����                                5 �������
    
    // ��� � �������. 32d �� 032d ���������� ������
    $format= '�� %2$s ����� %1$032d �������';
    $ff =  sprintf($format, 5, '������'); // �� ������ ����� 00000000000000000000000000000005 �������

    $msg = sprintf("���������: %d = %d %s %d\n", $res, $val, $op, $places);
    
    echo $msg;
    echo " ���������� ���:\n";
    
    $msg1 = sprintf("  val=%d\n", $val);
    $msg2 = sprintf("  shift=%d\n", $res);
    
    $st = PHP_INT_SIZE;
    $format = '%0' . (PHP_INT_SIZE * 8) . "b\n";
    
    echo "$msg1 \n $msg2";
    echo " �������� ���:\n";
    
    ////���� $format = %32b ��  val=                             100
    ///���� $format = %032b �� val = 00000000000000000000000000000100 �������� 0 ����� % ���������, 
    //����� ������ �������� ����������� ������. ��� �� ���. 
    $msg3 = sprintf('  val=' . $format, $val); // ��� val=00000000000000000000000000000100
    $msg4 = sprintf('  res=' . $format, $res); // ��������� res=00000000000000000000000000000010
    $msg0 = sprintf(' %2$s %d', $places, $op); // �������� 1 >> 
    echo "$msg3 \n $msg4"; 
    
    if ($note) {
        echo " ���������: $note\n";
    }

    echo "\n";
}
?>
