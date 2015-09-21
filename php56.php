<?php
/**
 * Created by PhpStorm.
 * User: kudryashov
 * Date: 9/3/15
 * Time: 12:25 PM
 */
// CONST expressions
//It is now possible to provide a scalar expression involving numeric and string literals and/or
//constants in contexts where PHP previously expected a static value, such as constant and
//property declarations and default function arguments.
const ONE = 1;
const TWO = ONE * 2;
class C {
    const THREE = TWO + 1;
    const ONE_THIRD = ONE / self::THREE;
    const SENTENCE = 'The value of THREE is ' . self::THREE;

    public function f($a = ONE + self::THREE) {
        return $a;
    }
}

echo (new C)->f()."\n";
echo C::SENTENCE;

// Constant arrays
const ARR = ['a', 'b'];

echo "\nConstant arrays result: " . ARR[0];

// Variadic functions
function f($req, $opt = null, ...$params) {
    // $params is an array containing the remaining arguments.
    printf('$req: %d; $opt: %d; number of params: %d'."\n",
        $req, $opt, count($params));
}

f(1);
f(1, 2);
f(1, 2, 3);
f(1, 2, 3, 4);
f(1, 2, 3, 4, 5);


//Argument unpacking via ... splat
function add($a, $b, $c) {
    return $a + $b + $c;
}
$operators = [2, 3];
echo add(1, ...$operators); // returns 6

//Exponentiation via **
//A right associative ** operator has been added to support exponentiation, along
//with a **= shorthand assignment operator.
printf("2 ** 3 ==      %d\n", 2 ** 3);         //2 ** 3 ==      8
printf("2 ** 3 ** 2 == %d\n", 2 ** 3 ** 2);    //2 ** 3 ** 2 == 512
$a = 2;
$a **= 3;
printf("a ==           %d\n", $a);             //a ==           8

//use function and use const
namespace Name\Space {
    const FOO = 42;
    function f() { echo __FUNCTION__."\n"; }
}

namespace {
    use const Name\Space\FOO;
    use function Name\Space\f;

    echo FOO."\n";                  //42
    f();                            //Name\Space\f
}

//GMP supports operator overloading
//GMP objects now support operator overloading and casting to scalar types.
//This allows for more expressive code using GMP:
$a = gmp_init(42);
$b = gmp_init(17);

// Pre-5.6 code:
var_dump(gmp_add($a, $b));
var_dump(gmp_add($a, 17));
var_dump(gmp_add(42, $b));

// New code:
var_dump($a + $b);
var_dump($a + 17);
var_dump(42 + $b);

//hash_equals() for timing attack safe string comparison
//The hash_equals() function has been added to compare two strings in constant time.
//This should be used to mitigate timing attacks; for instance, when testing crypt()
//password hashes (assuming that you are unable to use password_hash() and password_verify(),
//which aren't susceptible to timing attacks).
$expected  = crypt('12345', '$2a$07$usesomesillystringforsalt$');
$correct   = crypt('12345', '$2a$07$usesomesillystringforsalt$');
$incorrect = crypt('1234',  '$2a$07$usesomesillystringforsalt$');

var_dump(hash_equals($expected, $correct));         //bool(true)
var_dump(hash_equals($expected, $incorrect));       //bool(false)

// New magic method __debugInfo() which has been added to allow objects to change the properties and values
// that are shown when the object is output using var_dump().

class C {
    private $prop;

    public function __construct($val) {
        $this->prop = $val;
    }

    public function __debugInfo() {
        return [
            'propSquared' => $this->prop ** 2,
        ];
    }
}

var_dump(new C(42)); // object(C)#1 (1) {
                     //  ["propSquared"]=>
                     //   int(1764)
                     // }

//Also: The gost-crypto hash algorithm has been added. This implements the GOST hash
//function using the CryptoPro S-box tables as specified by http://www.faqs.org/rfcs/rfc4357.html

//SSL/TLS improvements:
//A wide range of improvements have been made to the SSL/TLS support in PHP 5.6. These include
//enabling peer verification by default, supporting certificate fingerprint matching, mitigating
//against TLS renegotiation attacks, and many new SSL context options to allow more fine grained
//control over protocol and verification settings when using encrypted streams.
//These changes are described in more detail in the OpenSSL changes in PHP 5.6.x section
//of this migration guide: http://php.net/manual/en/migration56.openssl.php

//pgsql async support:
//The pgsql extension now supports asynchronous connections and queries, thereby enabling non-blocking
//behaviour when interacting with PostgreSQL databases. Asynchronous connections may be established
//via the PGSQL_CONNECT_ASYNC constant, and the new pg_connect_poll(), pg_socket(), pg_consume_input()
//and pg_flush() functions may be used to handle asynchronous connections and queries.