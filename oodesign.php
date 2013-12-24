<?php
/**
 * oodesign  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */

/**
 * Factory Pattern
 */
 class Configuration {
    const STORE_INI = 1;
    const STORE_DB = 2;
    const STORE_XML = 3;
    public static function getStore($type = self::STORE_XML)
    {
        switch ($type) {
        case self::STORE_INI:
        return new Configuration_Ini();
        case self::STORE_DB:
        return new Configuration_DB();
        case self::STORE_XML:
        return new Configuration_XML();
        default:
        throw new Exception("Unknown Datastore Specified.");
    }
    }
    }
    class Configuration_Ini 
    {
    
    }
    class Configuration_DB 
    {
    
    }
    class Configuration_XML 
    {
    
    }
    
    $config = Configuration::getStore(Configuration::STORE_XML);

 

// registry pattern

class Registry
{
    private static $_register;
    public static function add(&$item, $name = null)
    {
        if (is_object($item) && is_null($name)) {
            $name = get_class($item);
        } elseif (is_null($name)) {
            $msg = "You must provide a name for non-objects";
            throw new Exception($msg);
        }
        $name = strtolower($name);
        self::$_register[$name] = $item;
    }
    // будет возвращена ссылка на соединение а не само соединение
    public static function &get($name) // 
    {
        $name = strtolower($name);
        if (array_key_exists($name, self::$_register)) {
            return self::$_register[$name];
        } else {
        $msg = "вЂ™$nameвЂ™ is not registered.";
        throw new Exception($msg);
        }
    }

    public static function exists($name)
    {
        $name = strtolower($name);
        if (array_key_exists($name, self::$_register)) {
            return true;
        } else {
            return false;
        }
    }
}

$db = new DB();
Registry::add($db);
// Later on
if (Registry::exists('DB')) {
    $db = Registry::get('DB'); // будет возвращена ссылка
    $db->_key = 2;
    $vb = Registry::get('DB'); // будет возвращена ссылка
} else {
    die('We lost our Database connection somewhere. Bear with us.');
}
class DB
{
    public $_key = 1;
    public $_key_2 = 2;
    protected $_key_3 = 3;
    protected $_key_4 = 4;

    public function getKey(){
        return $this->_key_4;
    }
}

/*
interface ArrayAccess { // cannot redeclase arrayAccess inteface 
    function offsetSet($offset, $value);
    function offsetGet($offset);
    function offsetUnset($offset);
    function offsetExists($offset);
}*/

// Доступ к объекту, как к массиву
class myArray implements ArrayAccess
{
    protected $_array;

    function  offsetSet($offset, $value) {
        $this->_array[$offset] = $value;
    }

    function  offsetGet($offset) {
        return $this->_array[$offset];
    }

    public  function  offsetExists($offset) {
        return array_key_exists($offset, $this->_array);
    }

    public  function  offsetUnset($offset) {
        unset($this->_array[$offset]);
    }

    // этот метод будет абсолютно нормально работать
    public function insider()
    {
        $this['start'] = 1;
        $start = $this['start'];
    }
}

$my = new myArray();
$my['start'] = 1; //offsetSet
$start = $my['start']; //offsetGet
$arrk = array_key_exists('start', $my); // offsetExists в этом случае не отрабатывает
$arriss = isset($my['start']); // offsetExists
unset($my['start']); //offsetUnset
$my->insider(); // работает как и в любом другом классе

/**
 * Поисковый итератор на всякий случай
 * 
 * interface SeekableIterator {
    function current();
    function next();
    function rewind();
    function key();
    function valid();
    function seek($index);
    }
 */

/**
 * Интерфейс итератор
 */
class myIterator implements Iterator
{
    private $_myData = array(
                        "foo",
                        "bar",
                        "baz",
                        "bat");
    private $_current = 0;

    function current() { // возвращаем текущее значение
        return $this->_myData[$this->_current];
    }
    function next() {
        $this->_current += 1;
    }
    function rewind() { // ставим номер итерации
        $this->_current = 0;
    }
    function key() {// возвращаем текущий ключ
        return $this->_current;
    }
    function valid() {
        return isset($this->_myData[$this->_current]);
    }    
}

$data = new myIterator();
foreach ($data as $key => $value) { //rewind -> valid -> current -> key -> next(на второй и более итерации)
    echo "$key: $value\n";
}

// Интерфейс Recursive Iterator
$company = array(
                array("Acme Anvil Co."),
                    array(
                        array("Human Resources",
                            array("Tom", "Dick", "Harry")),
                        array("Accounting",
                            array("Zoe", "Duncan", "Jack", "Jane"))));

class CompanyIterator extends RecursiveIteratorIterator
{
    function beginChildren()
    {
        if ($this->getDepth() >= 3) {
            echo str_repeat("\t", $this->getDepth() - 1);
            echo "<ul>" . PHP_EOL;
        }
    }
    function endChildren()
    {
        if ($this->getDepth() >= 3) {
            echo str_repeat("\t", $this->getDepth() - 1);
            echo "</ul>" . PHP_EOL;
        }
    }
}
class RecursiveArrayObject extends ArrayObject
{
    function  getIterator() {
        return new RecursiveArrayIterator($this); // вызывается вместо конструктора при new CompanyIterator($rec)
    }
}
$rec = new RecursiveArrayObject($company); //extends ArrayObject
$it = new CompanyIterator($rec); //extends RecursiveIteratorIterator

$in_list = false;
foreach ($it as $item) {//CompanyIterator::beginChildren() -> CompanyIterator::endChildren()->
                        //CompanyIterator::beginChildren() в конце и на след итерацию снова beginChildren() и т.д.
    echo str_repeat("\t", $it->getDepth());
    switch ($it->getDepth()) {
        case 1:
        echo "<h1>Company: $item</h1>" . PHP_EOL;
        break;
        case 2:
        echo "<h2>Department: $item</h2>" . PHP_EOL;
        break;
        default:
        echo "<li>$item</li>" . PHP_EOL;
    }
}
/////////////////////////////////////////////////

class NumberFilter extends FilterIterator
{
    const FILTER_EVEN = 1;
    const FILTER_ODD = 2;
    private $_type;

    function __construct($iterator, $odd_or_even = self::FILTER_EVEN)
    {
        $this->_type = $odd_or_even; // четный
        parent::__construct($iterator);
    }

    function accept()
    {
        if ($this->_type == self::FILTER_EVEN) {
            return ($this->current() % 2 == 0);
        }else {
            return ($this->current() % 2 == 1);
        }
    }
}

$numbers = new ArrayObject(range(0, 10)); // создаем объект - массив
$numbers_it = new ArrayIterator($numbers); // и итератор массива
$it = new NumberFilter($numbers_it, NumberFilter::FILTER_ODD); //extends FilterIterator

foreach ($it as $number) { //на каждой итерации NumberFilter::accept() по 2 раза вызывается
    echo $number . PHP_EOL;
}
