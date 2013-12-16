<?
error_reporting(E_ALL);
ini_set('display_errors','on');
ini_set('display_startup_errors','on');

$st = ('1top' == 1); // true 
$st = ('2top' == 1); // false - очевидно по первому биту смотрит
$st3 = ('1top' === 1); // false (разные типы)
$st2 = ('1top' == top);// false & notice - так как top  необъявленная константа

$test_one = "\x2a"; // здесь *
$test_two = "\052"; // и здесь *

$test_one = '\x2a'; // здесь \x2a
$test_two = '\052'; // здесь \052

$me = 'Davey';
$arr = array('Jack', 'Chuck', 'Jones');

$ja = "its me and my friend {$me}s";
$ja2 = "i now this guy his name {$arr[1]}[1987]";

$who = "Hello worls"; 
// ктати heredoc объявления чувствительны к регистру, т.е. <<<text это не правильно.
// кроме того впереди закр тега  не может быть пробелов. Ведет себя в точности как 
// строка с двойными кавычками, главным образом используется для тех строк, где много
// двойных кавычек - т.е. переменные и всякие escape последовательности включая ASCII
// коды будут интерполированы
$bzz = <<<TEXT
    So i sad him $who \x2a
TEXT;
// ни перед ни после замыкающего TEXT пробелы не ставятся, $bzz = So i sad him Hello worls *

$bzz =  <<<TEXT
So i sad him $who
TEXT;

$bzz = <<<EOT
So i sad him $who
EOT;

$txt = "Here is escaping a backslash: - \ -";

// кстати угловые скобки проескейпить нельзя. В таких случаях применяется примерно вот что
$st =  "Here’s a literal brace + dollar sign: {\$";

/**
 *Конечно же вот это вызовет ошибку парсера - здеcь heredoc применять нельзя
    class Hello 
    {
            public $zz = <<<TEXT
            hi man! 
            TEXT;
    }
*/




//замещает все вхождения первого символа вторым
$r0 = strtr('basa', 'a', 'b'); //получим bbsb
$r = strtr('basa', 'a', 'bc'); //получим bbsb - те. в подстановке "c" отбрасывается

// $R и $r конечно же разные переменные. Это только операторы регистронезависимые

//находит первое вхождение подстроки
//If TRUE, strstr() returns the part of the haystack before the first occurrence of the needle. 
$R = strstr('basa', 'a');  // получим asa

$a = '1';
$b = '2';
$test_error_and = ($a=='1' And $b == '2')  ? 'right' : 'error' ; // вернул right и никакой ошибки

$R2 = strstr('abs', 'b'); //bs

$a = '123456';
$R3 = strtr($a, array(1=>'o', 2=>'t')); // получим ot3456

// также строки можно использовать как массивы
$s = $a[2];// здесь 3
$s = $a['136']; // здесь пустая строка и notice: uninitialized string offset

$f = array('st'=>null);

$a = $f['st']; // a = null 

if($a == 1 ){ // при этой конструкции нотасса нет, это не то же что и unset($a);
    $msg = 'она null но не разустановлена'; 
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

if($a == null){ // да а здесь вылетает noticе т.к. $a разустановлена
    // но что характерно - $a таки равно null, т.е. в это условие мы попадаем
    $msg = 'проверка на null и нотайс';
}
//Вывод: unset()  и приравнивание к null это не совсем одно и то же. При unset 
//notice вылетает а при приравнивании нет (если совершаются действия с переменной)

$string = '123fh';
if($string == 123) 
{
    $msg = 'здесь true тк сравниваются 123 и 123, поэтому нужно использовать === ';
}

// сравнение строк - нужно обратить внимание на странный порядок - если строки одинаковы
// то он вернет 0, а если неодинаковы то 1
// то есть 0 - нет разницы. 1 - есть разница
$r = strcmp('google', 'Google'); // с учетом регистра - строки не идентичны и он вернул 1
$r = strcasecmp('google', 'Google'); // без учета регистра: строки идентичны и он вернул 0

//сравнивает первые 4 символа
$r = strncasecmp('123459kkflf','1234flfldlf',4); //0 потому что идентичны

// сравнение подстрок
// первый параметр - это старт с позиции
// второй параметр - это длина
// case insensitivity это третий параметр
$r = substr_compare('mamma find a condoms', 'find a Condoms', 7, 4, 1);
$r2 = substr_compare('mamma find a condoms', 'find a Condoms', 7, 4, 1);

// находит позицию ПЕРВОГО вхождения подстроки в строку
$r = strpos('123456789', '6789'); // 5 (потому что с нуля)

//кстати элементы в строках начинаются с 0. Если ничего не найдено,  strpos 
//вернет false . если найдено то может вернуть и 0 позицию, следует быть осторожным
$r = strstr('123456789', '67'); // 6789 
//stripos(); то же что и strpos(); но case-insensitive 
//stristr(); то же что и strstr(); но case-insensitive

//находит позицию ПОСЛЕДНЕГО вхождения подстроки в строку
//по факту то же что и strpos - только от конца строки 
$r = strrpos('123456789', '67'); // тоже 5 т.к. '67' является первым и последним вхождением в строку 

//Возвращает ДЛИНУ УЧАСТКА в начале строки str1, любой символ которого входит в строку str2. 
//присвоит 2 переменной $var, так как "42" - это самый длинный участок строки, 
//состоящий только из символов "1234567890". 
$var = strspn("42 is the answer, what is the question ...", "1234567890");
$r = strspn('182839 1hsksk','189'); // вернул 2

//Возвращает длину участка в начале строки str1, который не содержит ни одного символа из строки str2.
$r = strcspn('283 91hsksk','189'); // вернул 1

$string = '133445abcdef';
$mask = '12345';
$strspn =  strspn($string, $mask); // Выведет 6
$strcspn = strcspn($string, $mask); //Выведет 0 

$r = strspn('1abc234','abc','1','4'); // третий параметр - start, четвертый - длина выведет 3

// str_replace регистронезависимый реплейс, причем четвертый параметр - это кол-во совпавших
$r = str_ireplace('world', 'reader', 'Hello World Best World Favorite World', 
        $count); // Hello reader Best reader Favorite reader и еще  $count = 3

// получим Bonjour Le World
$r = str_replace(array('Hello', 'World'), array('Bonjour', 'Le World'), 'Hello World');

//получим darova darova 
$r = str_replace(array('Hello', 'World'), 'darova', 'Hello World');

//меняется слово начиная с 6 вхождения 
$r = substr_replace('Hello world', 'Reader', '6');// Hello Reader

//Опциональный четвертый параметры - это определение размера заменяемой строки -в данном случае меняем 4 символа
$r = substr_replace('Hello my little monkey world', 'Reader', 9, 4);//Hello my Readerle monkey world

// замена на пустую строку начиная с 8 вхождения 
$what = substr_replace('iden.82@gmail.com',"",strpos('iden.82@gmail.com','@')); // iden.82

//Ставим английско американскую локаль
$st = setlocale(LC_MONETARY, 'en_US'); //false почему то 

$x = '1234567';
// 2 начальная точка 4 длина
$xx = substr($x, 2, 4);// 3456
$xx = substr($x, -2); //67

$r = number_format('100000.698'); // локально независимая функция - то есть вне зависимости от setlocale
$r = number_format('100000.698','3', ",", " "); // 100 000,698 - кстати 3 аргумента не принимает

//
setlocale(LC_MONETARY, 'en_US');

//TODO:отработать разные варианты
//money_format('%2n','100000.698'); - кстати зависит от локали 
// мы можем задать правила форматирования как '%2n'

setlocale(LC_MONETARY, 'ja_JP.UTF-8');

setlocale(LC_MONETARY, 'en_US');

setlocale(LC_MONETARY, 'ja_JP.UTF-8');

number_format($number);

$ttu = sprintf('darova %s','kudrya');

printf('darova %s','kudrya');

sprintf('darova eto 100%% %s','kudrya'); // здесь %% это вывод % - т.е. символа процентов

$n = 123;
$f = 123.45;

$_n = sprintf('%b', $n); //1111011
$_f = sprintf('%b', $f); //1111011

$res = money_format('%.2n', "100000.698"); // 100000.70
$res = money_format('%i', "100000.698"); // 100000.70

//Output the character which has the input integer as its ASCII value
$_n = sprintf('%c', $n); // n=123 вывел {
$_f = sprintf('%c', $f); //f=123.5 вывел {

/**
 * Типы идентификаторов в printf функциях
 * 
% - символ процента. Аргумент не используется.
b - аргумент трактуется как целое и выводится в виде двоичного числа.
c - аргумент трактуется как целое и выводится в виде символа с соответствующим кодом ASCII.
d - аргумент трактуется как целое и выводится в виде десятичного числа со знаком.
e - аргумент трактуется как число в в научной нотации (например, 1.2e+2). Описатель
 *  точности указывает на количество знаков после запятой, начиная с версии PHP 5.2.1.
 *  В более ранних версиях он обозначал количество значащих цифр (на один знак меньше).
E - аналогично %e, но использует заглавную букву (например, 1.2E+2).
u - аргумент трактуется как целое и выводится в виде десятичного числа без знака.
f - аргумент трактуется как число с плавающей точкой и также выводится в зависимости от локали.
F - аргумент трактуется как число с плавающей точкой и также выводится, но без зависимости 
 * от локали. Доступно, начиная с версии PHP 4.3.10 и PHP 5.0.3.
g - выбирает самую краткую запись из %e и %f.
G - выбирает самую краткую запись из %E и %f.
o - аргумент трактуется как целое и выводится в виде восьмеричного числа.
s - аргумент трактуется как строка.
x - аргумент трактуется как целое и выводится в виде шестнадцатиричного числа (в нижнем регистре).
X - аргумент трактуется как целое и выводится в виде шестнадцатиричного числа (в верхнем регистре).

 */

$n =  43951789;
$u = -43951789;
$c = 65; // ASCII 65 is 'A'

// заметьте, двойной %% выводится как одинарный '%'
printf("%%b = '%b'\n", $n); // двоичное представление
printf("%%c = '%c'\n", $c); // выводит символ ascii, аналогично функции chr()
printf("%%d = '%d'\n", $n); // обычное целое число
printf("%%e = '%e'\n", $n); // научная нотация
printf("%%u = '%u'\n", $n); // беззнаковое целое представление положительного числа
printf("%%u = '%u'\n", $u); // беззнаковое целое представление отрицательного числа
printf("%%f = '%f'\n", $n); // представление числа с плавающей точкой
printf("%%o = '%o'\n", $n); // восьмеричное представление
printf("%%s = '%s'\n", $n); // строка
printf("%%x = '%x'\n", $n); // шестнадцатеричное представление (нижний регистр)
printf("%%X = '%X'\n", $n); // шестнадцатеричное представление (верхний регистр)

printf("%%+d = '%+d'\n", $n); // описатель знака с положительным целым числом
printf("%%+d = '%+d'\n", $u); // описатель знака с отрицательным целым числом


$format= 'На %2$s сидят %1$04d обезьян';
$ff =  sprintf($format, $num, $location);//На дереве сидят 0005 обезьян
// 04d - то есть вот эта штука говорит нам что число d будет выведено в 
// четырехзначном виде (макс вариант - 32 для 32 битных машин и 64 для 64 битных соотв)




$_n = sprintf('%d', '123'); //123
printf('%d', $n);
$_f = sprintf('%d', '123.45'); //123
printf('%d', $f);

//Output a number using scientific notation (e.g., 3.8e+9) 
$_n = sprintf('%e', '123'); // 1.230000e+2
$_f = sprintf('%e', '123.45'); //1.234500e+2

//the argument is treated as an integer, and presented as an unsigned decimal number. 
$_n = sprintf("%u", '123'); // работает точно так же как и одинарные кавычки 123
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

//s - строка
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

если подсунуть $data = '12a 456 789';
т.е. заведомо несоответствие формату, то будет
То результатом будет то что ниже, т.е. зафейлит оставшиеся значения (без нотайса)
ARRAY "$sscanf" = Array [3]	
	INT 0 = (int) 12	
	NULL 1 = null	
	NULL 2 = null
 */

// regular expressions

// Метасимволы регулярок
/**
 * . Match any character
 * ^ Match the start of the string
 * $ Match the end of the string
 * \s Match any whitespace character
 * \d Match any digit
 * \w Match any “word” character
 */

//Квантификаторы
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
 
                     