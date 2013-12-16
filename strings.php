<?
error_reporting(E_ALL);
ini_set('display_errors','on');
ini_set('display_startup_errors','on');

$st = ('1top' == 1); // true 
$st = ('2top' == 1); // false - �������� �� ������� ���� �������
$st3 = ('1top' === 1); // false (������ ����)
$st2 = ('1top' == top);// false & notice - ��� ��� top  ������������� ���������

$test_one = "\x2a"; // ����� *
$test_two = "\052"; // � ����� *

$test_one = '\x2a'; // ����� \x2a
$test_two = '\052'; // ����� \052

$me = 'Davey';
$arr = array('Jack', 'Chuck', 'Jones');

$ja = "its me and my friend {$me}s";
$ja2 = "i now this guy his name {$arr[1]}[1987]";

$who = "Hello worls"; 
// ����� heredoc ���������� ������������� � ��������, �.�. <<<text ��� �� ���������.
// ����� ���� ������� ���� ����  �� ����� ���� ��������. ����� ���� � �������� ��� 
// ������ � �������� ���������, ������� ������� ������������ ��� ��� �����, ��� �����
// ������� ������� - �.�. ���������� � ������ escape ������������������ ������� ASCII
// ���� ����� ���������������
$bzz = <<<TEXT
    So i sad him $who \x2a
TEXT;
// �� ����� �� ����� ����������� TEXT ������� �� ��������, $bzz = So i sad him Hello worls *

$bzz =  <<<TEXT
So i sad him $who
TEXT;

$bzz = <<<EOT
So i sad him $who
EOT;

$txt = "Here is escaping a backslash: - \ -";

// ������ ������� ������ ������������ ������. � ����� ������� ����������� �������� ��� ���
$st =  "Here�s a literal brace + dollar sign: {\$";

/**
 *������� �� ��� ��� ������� ������ ������� - ���c� heredoc ��������� ������
    class Hello 
    {
            public $zz = <<<TEXT
            hi man! 
            TEXT;
    }
*/




//�������� ��� ��������� ������� ������� ������
$r0 = strtr('basa', 'a', 'b'); //������� bbsb
$r = strtr('basa', 'a', 'bc'); //������� bbsb - ��. � ����������� "c" �������������

// $R � $r ������� �� ������ ����������. ��� ������ ��������� �������������������

//������� ������ ��������� ���������
//If TRUE, strstr() returns the part of the haystack before the first occurrence of the needle. 
$R = strstr('basa', 'a');  // ������� asa

$a = '1';
$b = '2';
$test_error_and = ($a=='1' And $b == '2')  ? 'right' : 'error' ; // ������ right � ������� ������

$R2 = strstr('abs', 'b'); //bs

$a = '123456';
$R3 = strtr($a, array(1=>'o', 2=>'t')); // ������� ot3456

// ����� ������ ����� ������������ ��� �������
$s = $a[2];// ����� 3
$s = $a['136']; // ����� ������ ������ � notice: uninitialized string offset

$f = array('st'=>null);

$a = $f['st']; // a = null 

if($a == 1 ){ // ��� ���� ����������� ������� ���, ��� �� �� �� ��� � unset($a);
    $msg = '��� null �� �� ��������������'; 
}
unset($a);

$a = 10;


function test(&$var){
    $var = $var/2;
    return $var;
}
$r = test(100);

one();
subone();

two();
subtwo();

function one() {
    function subone(){}
} 

function two(){
    function subtwo(){}
}

if($a == null){ // �� � ����� �������� notic� �.�. $a ��������������
    // �� ��� ���������� - $a ���� ����� null, �.�. � ��� ������� �� ��������
    $msg = '�������� �� null � ������';
}
//�����: unset()  � ������������� � null ��� �� ������ ���� � �� ��. ��� unset 
//notice �������� � ��� ������������� ��� (���� ����������� �������� � ����������)

$string = '123fh';
if($string == 123) 
{
    $msg = '����� true �� ������������ 123 � 123, ������� ����� ������������ === ';
}

// ��������� ����� - ����� �������� �������� �� �������� ������� - ���� ������ ���������
// �� �� ������ 0, � ���� ����������� �� 1
// �� ���� 0 - ��� �������. 1 - ���� �������
$r = strcmp('google', 'Google'); // � ������ �������� - ������ �� ��������� � �� ������ 1
$r = strcasecmp('google', 'Google'); // ��� ����� ��������: ������ ��������� � �� ������ 0

//���������� ������ 4 �������
$r = strncasecmp('123459kkflf','1234flfldlf',4); //0 ������ ��� ���������

// ��������� ��������
// ������ �������� - ��� ����� � �������
// ������ �������� - ��� �����
// case insensitivity ��� ������ ��������
$r = substr_compare('mamma find a condoms', 'find a Condoms', 7, 4, 1);
$r2 = substr_compare('mamma find a condoms', 'find a Condoms', 7, 4, 1);

// ������� ������� ������� ��������� ��������� � ������
$r = strpos('123456789', '6789'); // 5 (������ ��� � ����)

//������ �������� � ������� ���������� � 0. ���� ������ �� �������,  strpos 
//������ false . ���� ������� �� ����� ������� � 0 �������, ������� ���� ����������
$r = strstr('123456789', '67'); // 6789 
//stripos(); �� �� ��� � strpos(); �� case-insensitive 
//stristr(); �� �� ��� � strstr(); �� case-insensitive

//������� ������� ���������� ��������� ��������� � ������
//�� ����� �� �� ��� � strpos - ������ �� ����� ������ 
$r = strrpos('123456789', '67'); // ���� 5 �.�. '67' �������� ������ � ��������� ���������� � ������ 

//���������� ����� ������� � ������ ������ str1, ����� ������ �������� ������ � ������ str2. 
//�������� 2 ���������� $var, ��� ��� "42" - ��� ����� ������� ������� ������, 
//��������� ������ �� �������� "1234567890". 
$var = strspn("42 is the answer, what is the question ...", "1234567890");
$r = strspn('182839 1hsksk','189'); // ������ 2

//���������� ����� ������� � ������ ������ str1, ������� �� �������� �� ������ ������� �� ������ str2.
$r = strcspn('283 91hsksk','189'); // ������ 1

$string = '133445abcdef';
$mask = '12345';
$strspn =  strspn($string, $mask); // ������� 6
$strcspn = strcspn($string, $mask); //������� 0 

$r = strspn('1abc234','abc','1','4'); // ������ �������� - start, ��������� - ����� ������� 3

// str_replace ������������������� �������, ������ ��������� �������� - ��� ���-�� ���������
$r = str_ireplace('world', 'reader', 'Hello World Best World Favorite World', 
        $count); // Hello reader Best reader Favorite reader � ���  $count = 3

// ������� Bonjour Le World
$r = str_replace(array('Hello', 'World'), array('Bonjour', 'Le World'), 'Hello World');

//������� darova darova 
$r = str_replace(array('Hello', 'World'), 'darova', 'Hello World');

//�������� ����� ������� � 6 ��������� 
$r = substr_replace('Hello world', 'Reader', '6');// Hello Reader

//������������ ��������� ��������� - ��� ����������� ������� ���������� ������ -� ������ ������ ������ 4 �������
$r = substr_replace('Hello my little monkey world', 'Reader', 9, 4);//Hello my Readerle monkey world

// ������ �� ������ ������ ������� � 8 ��������� 
$what = substr_replace('iden.82@gmail.com',"",strpos('iden.82@gmail.com','@')); // iden.82

//������ ��������� ������������ ������
$st = setlocale(LC_MONETARY, 'en_US'); //false ������ �� 

$x = '1234567';
// 2 ��������� ����� 4 �����
$xx = substr($x, 2, 4);// 3456
$xx = substr($x, -2); //67

$r = number_format('100000.698'); // �������� ����������� ������� - �� ���� ��� ����������� �� setlocale
$r = number_format('100000.698','3', ",", " "); // 100 000,698 - ������ 3 ��������� �� ���������

//
setlocale(LC_MONETARY, 'en_US');

//TODO:���������� ������ ��������
//money_format('%2n','100000.698'); - ������ ������� �� ������ 
// �� ����� ������ ������� �������������� ��� '%2n'

setlocale(LC_MONETARY, 'ja_JP.UTF-8');

setlocale(LC_MONETARY, 'en_US');

setlocale(LC_MONETARY, 'ja_JP.UTF-8');

number_format($number);

$ttu = sprintf('darova %s','kudrya');

printf('darova %s','kudrya');

sprintf('darova eto 100%% %s','kudrya'); // ����� %% ��� ����� % - �.�. ������� ���������

$n = 123;
$f = 123.45;

$_n = sprintf('%b', $n); //1111011
$_f = sprintf('%b', $f); //1111011

$res = money_format('%.2n', "100000.698"); // 100000.70
$res = money_format('%i', "100000.698"); // 100000.70

//Output the character which has the input integer as its ASCII value
$_n = sprintf('%c', $n); // n=123 ����� {
$_f = sprintf('%c', $f); //f=123.5 ����� {

/**
 * ���� ��������������� � printf ��������
 * 
% - ������ ��������. �������� �� ������������.
b - �������� ���������� ��� ����� � ��������� � ���� ��������� �����.
c - �������� ���������� ��� ����� � ��������� � ���� ������� � ��������������� ����� ASCII.
d - �������� ���������� ��� ����� � ��������� � ���� ����������� ����� �� ������.
e - �������� ���������� ��� ����� � � ������� ������� (��������, 1.2e+2). ���������
 *  �������� ��������� �� ���������� ������ ����� �������, ������� � ������ PHP 5.2.1.
 *  � ����� ������ ������� �� ��������� ���������� �������� ���� (�� ���� ���� ������).
E - ���������� %e, �� ���������� ��������� ����� (��������, 1.2E+2).
u - �������� ���������� ��� ����� � ��������� � ���� ����������� ����� ��� �����.
f - �������� ���������� ��� ����� � ��������� ������ � ����� ��������� � ����������� �� ������.
F - �������� ���������� ��� ����� � ��������� ������ � ����� ���������, �� ��� ����������� 
 * �� ������. ��������, ������� � ������ PHP 4.3.10 � PHP 5.0.3.
g - �������� ����� ������� ������ �� %e � %f.
G - �������� ����� ������� ������ �� %E � %f.
o - �������� ���������� ��� ����� � ��������� � ���� ������������� �����.
s - �������� ���������� ��� ������.
x - �������� ���������� ��� ����� � ��������� � ���� ������������������ ����� (� ������ ��������).
X - �������� ���������� ��� ����� � ��������� � ���� ������������������ ����� (� ������� ��������).

 */

$n =  43951789;
$u = -43951789;
$c = 65; // ASCII 65 is 'A'

// ��������, ������� %% ��������� ��� ��������� '%'
printf("%%b = '%b'\n", $n); // �������� �������������
printf("%%c = '%c'\n", $c); // ������� ������ ascii, ���������� ������� chr()
printf("%%d = '%d'\n", $n); // ������� ����� �����
printf("%%e = '%e'\n", $n); // ������� �������
printf("%%u = '%u'\n", $n); // ����������� ����� ������������� �������������� �����
printf("%%u = '%u'\n", $u); // ����������� ����� ������������� �������������� �����
printf("%%f = '%f'\n", $n); // ������������� ����� � ��������� ������
printf("%%o = '%o'\n", $n); // ������������ �������������
printf("%%s = '%s'\n", $n); // ������
printf("%%x = '%x'\n", $n); // ����������������� ������������� (������ �������)
printf("%%X = '%X'\n", $n); // ����������������� ������������� (������� �������)

printf("%%+d = '%+d'\n", $n); // ��������� ����� � ������������� ����� ������
printf("%%+d = '%+d'\n", $u); // ��������� ����� � ������������� ����� ������


$format= '�� %2$s ����� %1$04d �������';
$ff =  sprintf($format, $num, $location);//�� ������ ����� 0005 �������
// 04d - �� ���� ��� ��� ����� ������� ��� ��� ����� d ����� �������� � 
// �������������� ���� (���� ������� - 32 ��� 32 ������ ����� � 64 ��� 64 ������ �����)




$_n = sprintf('%d', '123'); //123
printf('%d', $n);
$_f = sprintf('%d', '123.45'); //123
printf('%d', $f);

//Output a number using scientific notation (e.g., 3.8e+9) 
$_n = sprintf('%e', '123'); // 1.230000e+2
$_f = sprintf('%e', '123.45'); //1.234500e+2

//the argument is treated as an integer, and presented as an unsigned decimal number. 
$_n = sprintf("%u", '123'); // �������� ����� ��� �� ��� � ��������� ������� 123
$_n = sprintf('%u', '123'); //123
$_f = sprintf('%u', '123.45'); //123

//f - Output a locale aware float number
$_n = sprintf('%f', $n); //123.000000
$_f = sprintf('%f', $f); //123.450000

//F - Output a non-locale aware float number
$_n = sprintf('%F', '123'); // 123.000000
$_f = sprintf('%F', '123.45'); // 123.450000

//o - the argument is treated as an integer, and presented as an octal number.
$_n = sprintf('%o', '123'); //173
$_f = sprintf('%o', '123.45'); //173

//s - ������
$_n = sprintf('%s', '123');
$_f = sprintf('%s', '123.45');

//x -  Output a number as hexadecimal with lowercase letters
$_n = sprintf('%x', '123'); // 7b
$_f = sprintf('%x', '123.45'); // 7b

//X - Output a number as hexadecimal with uppercase letters
$_n = sprintf('%X', '123'); //7B
$_f = sprintf('%X', '123.45'); //7B

$data = '123 456 789';
$format = '%d %d %d';

//Parses input from a string according to a format
$sscanf = sscanf($data, $format);
echo "\n \n";
$sscanf_fail = sscanf('123a 456 789', $format);
/*
  	ARRAY "$sscanf" = Array [3]	
	INT 0 = (int) 123	
	INT 1 = (int) 456	
	INT 2 = (int) 789	

���� ��������� $data = '12a 456 789';
�.�. �������� �������������� �������, �� �����
�� ����������� ����� �� ��� ����, �.�. �������� ���������� �������� (��� �������)
ARRAY "$sscanf" = Array [3]	
	INT 0 = (int) 12	
	NULL 1 = null	
	NULL 2 = null
 */

// regular expressions

// ����������� ���������
/**
 * . Match any character
 * ^ Match the start of the string
 * $ Match the end of the string
 * \s Match any whitespace character
 * \d Match any digit
 * \w Match any �word� character
 */

//��������������
/**
 * * The character can appear zero or more times
 * + The character can appear one or more times
 * ? The character can appear zero or one times
 * {n,m} The character can appear at least n times, and no more than m.
        Either parameter can be omitted to indicated a minimum limit
        with no maximum, or a maximum limit without a minimum, but
        not both.
 */

$st = preg_match('/a(bc.)e/', 'abcue');// "."(point) at there - it corresponds one any symbol

$st = preg_match('/a(bc.)+e/', 'abczee'); // st = 1

$st = preg_match('/[a-zA-Z\s]/', 'Sergey Kudryashov'); // st = 1

$st = preg_match('/^(\w)+\s(\w)+/', 'Sergey Kudryashov', $capture); // array(3) (
                                                                    //  [0] => (string) Sergey Kudryashov
                                                                    //  [1] => (string) y
                                                                    //  [2] => (string) v
                                                                    //)

// multiple matches
$st = preg_match_all('/([abc])\d/', 'a1bb b2cc c2dd', $matchesarray); // $matchesarray
                                                                //0=>array(0=>a1
                                                                //1=>b2  2=>c2)
                                                                //1=>array(
                                                                //0=>a, 1=>b, 2=>c)
$body = '[b]Make me Bold[/b]';
$regexp = '@\[b\](.*?)\[/b\]@i'; // @ - is a delimiter
$replacement = "<b>$1</b>";
$res = preg_replace($regexp, $replacement, $body); // $res =  <b>Make me Bold</b>
                                                  // 
                                                  // 

// also may exists array variant
$subjects['bold'] = '[b]Make me Bold[/b]';
$subjects['italic'] = '[i]Make me Italic[/i]';

$patterns[] = '@\[b\](.*?)\[/b\]@i';
$patterns[] = '@\[i\](.*?)\[/i\]@i';

$replacements[] = '<b>$1</b>';
$replacements[] = '<i>$1</i>';

$res1 = preg_replace($patterns, $replacement, $subjects); // return array(2) (
                                                          //[bold] => (string) <b>Make me Bold</b>
                                                          //[italic] => (string) <b>Make me Italic</b>
                                                          //)
 
                     