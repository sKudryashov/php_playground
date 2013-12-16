<?php
/**
 * xml  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */

/**
 * Что здесь важно - важен принцип формирования структуры xml элемента, и что
 * ставить в теги а что в атрибуты. Большой разницы между ними нет, но есть
 * такая рекомендация что теги - это сама информация, данные, а атрибуты
 * это вспомогательная информация, т.е. метаданные. Но это чистая абстракция
 * к примеру возьмем представление данных о книге в виде xml структуры
 *
 * Конечно же обязателен корневой элемент, у нас это library
 */

$data =  <<<XML
<?xml version="1.0"?>    
    
<library>
<book isbn="0345342968" >
<title>Fahrenheit 451</title>
<author>R. Bradbury</author>
<publisher>Del Rey</publisher>
</book>
<book isbn="0048231398">
<title>The Silmarillion</title>
<author>R. Bradbury</author>
</book>
<book isbn="0451524934" >
<title>1984</title>
<author>G. Orwell</author>
<publisher>Signet</publisher>
</book>
<book isbn="031219126X" >
<title>Frankenstein</title>
<author>M. Shelley</author>
<publisher>Bedford</publisher>
</book>
<book isbn="0312863551" >
<title>The Moon Is a Harsh Mistress</title>
<author>R. A. Heinlein</author>
<publisher>Orb</publisher>
</book>
</library>
XML;
/**
 * Simple Xml в пятерке мог разбирать только XML 1.0 формат, при разборе 1.1 simpleXml может выбрасывать
 * варнинги, как в 5.3 - не знаю
 */

// вот простой пример. Слабым его местом является то, что мы должны точно знать, 
// какие имена у элементов и атрибутов. Есть вариант с Xpath, а есть вариант и с 
// 
$vm = simplexml_load_string($data); // это одно и то же что и конструкция ниже
$s_xml = new SimpleXMLElement($data); // SimpleXMLElement object 
foreach($s_xml->book as $book){ //->SimpleXMLElement object
    $isbn = $book['isbn']->__toString();// атрибут  0345342968
    $title = $book->title->__toString(); // сущность Fahrenheit 451
    $author = $book->author->__toString(); // сущность R. Bradbury
    $publisher = $book->publisher; //SimpleXMLElement object {  CLASSNAME => (string) SimpleXMLElement }
}

//или такой вариант 
foreach ($s_xml->children() as $child){
    $childname = $child->getName();  // получаем book
    $attrs = $s_xml->attributes();   // получаем атрибуты как SimpleXmlElement
    
    foreach($child->children() as $ch){// теперь крутим в цикле ребенка и перебираем его элементы
        $ch_name = $ch->getName();  // а здесб author publisher etc
        $attrs = $ch->attributes();
        $attrs_str = $attrs->__toString(); // 
    }    
}

// фишка в том что xpath работает только с нижележащими элементами, то есть если мы находимся не в 
// корне а в элементе book то в рядом стоящих эл-тах book поиска не будет. оБЫЧНАЯ DOM модель короче
// метод xpath() возвращает всегда массив объектов SimpleXMLElement даже если найден только 1
$elbook = $s_xml->xpath('book'); //[0] => SimpleXMLElement object {
                                //    CLASSNAME => (string) SimpleXMLElement
                                //    @attributes => array(1) (
                                //      [isbn] => (string) 0345342968
                                //    )
                                //    title => (string) Fahrenheit 451
                                //    author => (string) R. Bradbury
                                //    publisher => (string) Del Rey
                                //  } и так далее...

foreach($elbook as $b){
    $el_name = $b; //SimpleXMLElement object
    $check = $el_name->__toString(); // пустая строка на всех итерациях
}

$eltitle = $s_xml->xpath('book/title'); //[0] => SimpleXMLElement object { CLASSNAME => (string) SimpleXMLElement }
foreach($eltitle as $title){
    echo $title;
    $check = $title->__toString(); //Fahrenheit 451 ... и так далее
}


$title_0 = $s_xml->book[0]->xpath('title'); //([0] => SimpleXMLElement object {CLASSNAME => (string) SimpleXMLElement } )
foreach ($title_0 as $t_0){
    $echo = $t_0->__toString; //SimpleXMLElement object
}

// ПО доступам к элементам вроде бы все. Теперь по модифицированию xml документов:,
// начиная с версии 5.1.3 есть возможность добавлять элементы в xml
// пример:
$book = $s_xml->addChild('book'); // SimpleXMLElement object вернет сразу добавленный эл-т
$book->addAttribute('isbn', '01');
$book->addChild('author', 'Viktor Pelevin');
$book->addChild('title', 'generation_p');
$book->addChild('publisher', 'Ivan Nepomnyashiy');
header('Content-type: text/xml');
// кстати в asXML() можно передать имя файла, в этом случае модифицированный xml будет сохранен в этом файле
// если файла не существует, метод создаст его, если файл существует - метод перезапишет его без всяких
// варнингов и нотайсов
// 
//echo $s_xml->asXML(); // а это вывод как XML
//
// удаление элемента из дерева в simpleXml выглядит так: 
$s_xml->book[1] = NULL; // в этом случае все что есть внутри элемента book удалится, но сам элемент останется
// таким же макаром удаляются атрибуты, но нюанс в том, что мы можем только обнулить атрибут, но сам атрибут 
// тоже не удалится. Просто будет атрибут пустой вот и все. Для более корректного удаления нам 
// желательно экспортнуть SimpleXml объект в объект DomDocument, где возможности по удалению более широкие.


/* ПРостранства имен в Xml */
// они нужны главным образом для того, чтобы не возникало конфликта имен
$data =  <<<XML
<?xml version="1.0"?>
<library xmlns="http://example.org/library"
xmlns:meta="http://example.org/book-meta"
xmlns:pub="http://example.org/publisher"
xmlns:foo="http://example.org/foo"
xmlns:jumbo="http://example.org/jumbo">
<book meta:isbn="0345342968">
<title>Fahrenheit 451</title>
<author>Ray Bradbury</author>
<bookshop>
    <shop_item xmlns:shops="http://example.org/shop">
        <shops:pushkina_boulevard>The world of book</shops:pushkina_boulevard>
    </shop_item>
</bookshop>
<pub:publisher>Del Rey</pub:publisher>
<foo:publisher>Juseppe Del Rey</foo:publisher>
</book>
</library>
XML;

$s_xml = new SimpleXMLElement($data);

//getDocNamespaces вернет все неймспейсы ОБЪЯВЛЕННЫЕ в документе
//getNamespaces вернет все неймспейсы ИСПОЛЬЗУЕМЫЕ в документе
$dnss = $s_xml->getDocNamespaces();// вернул все неймспейсы объявленные в документе, включая[]
                                    //array(5) (
                                    //  [] => (string) http://example.org/library
                                    //  [meta] => (string) http://example.org/book-meta
                                    //  [pub] => (string) http://example.org/publisher
                                    //  [foo] => (string) http://example.org/foo
                                    //  [jumbo] => (string) http://example.org/jumbo
                                    //)
$dnssr = $s_xml->getDocNamespaces(true); // и этот тоже, по идее передача true включает рекурсивное 
                                        // поведение, т.е. в этом случае я также получаю всех детей
                                        // Т.Е.  в массиве элемент shops, а если не передать true, то его не будет. 
                                        //array(6) (
                                        //  [] => (string) http://example.org/library
                                        //  [meta] => (string) http://example.org/book-meta
                                        //  [pub] => (string) http://example.org/publisher
                                        //  [foo] => (string) http://example.org/foo
                                        //  [jumbo] => (string) http://example.org/jumbo
                                        //  [shops] => (string) http://example.org/shop
                                        //)
$nss = $s_xml->getNamespaces(); // вернул [] => (string) http://example.org/library т.е. первый объявленный
$nssr = $s_xml->getNamespaces(true);//вернул все ИСПОЛЬЗУЕМЫЕ неймспейсы в себе и в дочерних элементах
                                    //[] => (string) http://example.org/library
                                    //[meta] => (string) http://example.org/book-meta
                                    //[pub] => (string) http://example.org/publisher
                                    //[foo] => (string) http://example.org/foo
                                    //[shops] => (string) http://example.org/shop

$nssr = null;

$url = 'http://uchitsya.com.ua/module/stat/echo/23';
$str_url = parse_url($url); //array(3) ( [scheme] => http [host] => uchitsya.com.ua [path] => /module/stat/echo/23 )

$dom = new DOMDocument();
$dom->loadXML($data);
//$str = $dom->loadHTMLFile('/xml/objects.html');// загрузить HTML файл в DOM объект
$dom->save('library.xml'); //сохранение в файл
$str = $dom->saveXML(); // сохранение в строчку
$html = $dom->saveHTML(); // сохранение в HTML формат хотя так визуально ничем не отличаются
$dom->saveHTMLFile('library_html.xml'); // сохранение в HTML файл

// помимо бесчисленного количества разных фукнций, которые я там увидел, в DOMDocument 
// есть возможность работать с xpath гораздо шире, чем в simpleXml
//!! Но нужно обратить внимание что работа с Xpath в DOM осушествляется через
// отдельный объект
$xpath = new DOMXPath($dom);

// продублировал - чтобы легче было разбираться
$data =  <<<XML
<?xml version="1.0"?>
<library xmlns="http://example.org/library"
xmlns:meta="http://example.org/book-meta"
xmlns:pub="http://example.org/publisher"
xmlns:foo="http://example.org/foo"
xmlns:jumbo="http://example.org/jumbo">
<book meta:isbn="0345342968">
<title>Fahrenheit 451</title>
<author>Ray Bradbury</author>
<bookshop>
    <shop_item xmlns:shops="http://example.org/shop">
        <shops:pushkina_boulevard>The world of book</shops:pushkina_boulevard>
    </shop_item>
</bookshop>
<pub:publisher>Del Rey</pub:publisher>
<foo:publisher>Juseppe Del Rey</foo:publisher>
</book>
</library>
XML;

// если я закомментирую эту функцию - регистрации неймспейса, и одновременно в 
// строке $data  уберу дефолтовый неймспейс xmlns="http://example.org/library"
// то xpath будет отдавать значения и без регистрации неймспейса. 
// если же я в $data не уберу строчку, xmlns="http://example.org/library" 
// а $xpath->registerNamespace закомментирую, то выражение $xpath->query("//title/text()");
// ничего не вернет. Кстати часть 'lib' здесь выступает своего рода алиасом для выполнения
// последующих запросов в рамках этого неймспейса, типа //lib:title/text()
$xpath->registerNamespace('lib', 'http://example.org/library'); // регистрация неймпспейса осущесвляется 
                                                                // для Xpath объекта в том смысле что
                                                                // поиск будет происходить только в неймспейсе
                                                                // http://example.org/library - 
                                                                // а lib это тот алиас - который мы назначаем 
                                                                // именно в контексте объекта Xpath для его 
                                                                // использования в методе query() как lib://lib:title
                                                                // в этом случае да, поиск будет проходить только 
                                                                // в неймспейсе http://example.org/library                                                          // Xpath - 

$result = $xpath->query("//lib:title/text()"); //Здесь мы взяли текст внутри тега title DOMNodeList
$result_title = $xpath->query("//lib:title");  // здесь получается мы выбрали сам тег title DOMNodeList
                                               //(но здесь мы доступ к тексту не получим уже)
$result_data = $result->item(0)->data; // обратить внимание как осуществляется доступ к элементу

// попробуем ка доступиться к найденным элементам в цикле 
foreach($result as $i => $r){
    $data = $r->data; // вернул строку Fahrenheit 451 - то есть доступ правильный $r - DOMText- экземпляр  
    $wholeText = $r->wholeText; // вернул строку Fahrenheit 451 - получается alias для data
}

foreach($result_title as $i => $r){
    $data = $r->data; // вернул null? странно, получается DOMElement не имеет свойства data?
                      // описание класса http://tr2.php.net/manual/en/class.domelement.php
    $tagName = $r->tagName; // вот по ходу свойство, которое отдает имя тега - вернул title
}
$result_without_text = $result_title->item(0)->data; // вернул null поскольку item(0) отдает нам экземпляр DOMElement
$result_title_data = $result_title->item(0)->tagName; // вернул имя тега title

if($result->length > 0){    
    $book = $result->item(0); //DOMText object
    echo $book->data;
    $_data = $book->data; // Fahrenheit 451
    
    foreach ($result as $res){ //$result - DOMNodeList object, $res - DOMText object
        $data_xpath = $res->data; // Fahrenheit 451
    }
}

// Создание элементов DOM
$book = $dom->createElement('book'); //DOMElement object
$book->setAttribute('meta:isbn', '099292939');

// создание элемента DomDocument и текста в нем 
$title = $dom->createElement('title'); //DOMElement object
$text = $dom->createTextNode('"php|architect’s Guide to PHP Design Patterns"'); //DOMText object
//$title->setAttribute('attr', 'we love you');
$title->setAttributeNS('http://something.com/ns1',
                        'ns1:mynamespace',
                        'jjjj'); 
                        // задавать данные строго  в таком формате 
                        // <title xmlns:ns1="http://something.com/ns1" ns1:mynamespace="jjjj"> в этот раз
                        // все правильно. Очевидно трабл был в том что я пытался поставить префикс пространства 
                        // имени как xmlns (сейчас ns1) If the attribute does not exist, it will be created. 
$title->appendChild($text);
$book->appendChild($title);
$dom->documentElement->appendChild($book); // добавляем наш элемент в дерево
// посмотрим промежуточные результаты наших действий -ага здесь пока еще ничего нет, нам нужно добавить это все
// в дерево DOM прежде чем дампить в строчку
$_xml_str = $dom->saveXML();
$_html_str = $dom->saveHTML();

$author = $dom->createElement('author', 'Jason E. Sweat');
// второй раз вызываем метод - установить атрибут неймспейса и смотрим как работает: правильно, так и должен
//<author xmlns:mynamespace="example.com/mynamespace" mynamespace:something="value">

$author->setAttributeNS('example.com/mynamespace', 'mynamespace:something','value');
$book->appendChild($author);

$publisher = $dom->createElement('pub:publisher','"Marco Tabini &amp; Associates, Inc."');
$book->appendChild($publisher);
$dom->documentElement->appendChild($book);
$_xml_str = $dom->saveXML();

$_html_str = $dom->saveHTML(); // 

// перенос элементов DOM 
$dom = new DOMDocument();
$dom->loadXML($_xml_str);

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('lib', 'http://example.org/library'); // регистрируем неймспейс
$result = $xpath->query('//lib:book'); // и находим все теги book которые ему соответствуют, причем lib - это алиас именно
                                        //в контексте запроса xpath - а не в контексте документа
// проверим ка что у нас тут найдено
foreach($result as $r){
    $item = $r->tagName;    // выдает book
}

$result = $xpath->query('//lib:book/text()'); // и текст внутри тега book

foreach($result as $r){
    $data = $r->data; //ничего не выдает потому как внутри другие теги
    $txt = $r->wholeText;   // это алиас
    //
    //1)$item_data = $r->item(0)->data;//
    //2)$hz = $r->item(0)->hasChildNodes(); поскольку мы в [path запросе запросили именно text() то понятно что у меня 
    //по вот этим выражениям что я задал выше 1 и 2 - вылетели фаталы    
}

$result->item(0)->parentNode->appendChild($result->item(0));
// методы appendChild и insertBefore - ПЕРЕМЕЩАЮТ элементы DOM
// если нужно продублировать, то есть такой метод cloneNode()
$item1 = $result->item(1);
$clone = $item1->cloneNode();
$clone->insertBefore($result->item(0));
$saved_changed_xml = $dom->saveXML();

// Пример изменения элементов DOM 
$xml = <<<XML
<xml>
<text>some text in here</text>    
</xml>
XML;

$dom = new DOMDocument();
$dom->loadXML($xml);

$xpath = new DOMXPath($dom);
$t1 = $xpath->query('//text/text()')->item(0);
$t2 = $xpath->query('//text')->item(0);
$t1->data = ucwords($t1->data); // во всех словах делаем первые буквы заглавными
$save = $dom->saveXML();

// Пример удаления данных в DOM
$xml = <<<XML
<xml>
    <text type="misc">some text here</text>
    <text type="misc">some more text here</text>
    <text type="misc">yet more text here</text>
</xml>
XML;

$dom = new DOMDocument();
$dom->loadXML($xml);

$xpath = new DOMXPath($dom);
$result = $xpath->query('//text');
$result_data = $result->item(0)->data;
$result->item(0)->parentNode->removeChild($result->item(0));
$control = $dom->saveHTML(); //<xml> 
                            //    <text type="misc">some more text here</text>
                            //    <text type="misc">yet more text here</text>
                            //</xml>
$result->item(1)->removeAttribute('type');

// !!здесь второй параметр переданный в query - это контекст, в котором будет происходить действие 
$result = $xpath->query('text()', $result->item(2)); //вернет some more text here

// здесь мы указываем при удалении данных смещение, с которого стартует удаление и длина удаляемого участка
$result->item(0)->deleteData(0, $result->item(0)->length); //в этом случае мы удалем все. Но можно и половинку если надо
$saved = $dom->saveXML(); //<xml><text>some more text here</text><text type="misc"></text></xml>
$saved_htm = $dom->saveHTML();

// осталось неймспейсы в DOM
$dom = new DOMDocument();
// это кагбе первый вариант использования - самый простой 
$node = $dom->createElement('ns1:somenode');
$node->setAttribute('ns2:comeattribute', 'somevalue');
$node2 = $dom->createElement('ns3:somenode');
$node2->setAttribute('ns4:someattr', 'somev');
$node->appendChild($node2);
$node->setAttribute('xmlns:ns1', 'http://example.com/ns1');
$node->setAttribute('xmlns:ns2', 'http://example.com/ns2');
$node->setAttribute('xmlns:ns3', 'http://example.com/ns3');
$dom->appendChild($node); // !!! Да да. Нам нужно сделать append child в dom объект корневого элемента
$xmlstr = $dom->saveXML();//<?xml version="1.0"знак вопроса>
                            //<ns1:somenode ns2:comeattribute="somevalue" 
                            //xmlns:ns1="http://example.com/ns1" 
                            //xmlns:ns2="http://example.com/ns2" 
                            //xmlns:ns3="http://example.com/ns3">
                            //  <ns3:somenode ns4:someattr="somev"/>
                            //  </ns1:somenode>

// а есть еще чуть более продвинутый 
$dom = new DOMDocument();
$node = $dom->createElementNS('http://example.com/ns1', 'ns1:somenode', 'somevalue');
$node->setAttributeNS('http://example.com/ns2', 'ns2:someattribute', 'someattrvalue');
$node1 = $dom->createElementNS('http://example.com/ns3', 'ns3:namespace3');
$node1->setAttributeNS('http://example.com/ns2', 'ns2:someattribute', 'someattrvalue');
$node2 = $dom->createElementNS('http://example.com/ns4', 'ns4:namespace4');
$node3 = $dom->createElementNS('http://example.com/ns5', 'ns5:namespace5');
$node4 = $dom->createElementNS('http://example.com/ns5', 'ns5:namespace5', 'namespace number five');
$node5 = $dom->createElementNS('http://example.com/ns1', 'ns1:somenode', 'some value 2');
$node->appendChild($node1);
$node->appendChild($node2);
$node->appendChild($node3);
$node->appendChild($node4);
$node->appendChild($node5);
$dom->appendChild($node);
$xmlstr;
$xml_str2 = $dom->saveXML();
/**
 * (string) <?xml version="1.0"?>
<ns1:somenode xmlns:ns1="http://example.com/ns1" 
 xmlns:ns2="http://example.com/ns2" 
 xmlns:ns3="http://example.com/ns3" 
 xmlns:ns4="http://example.com/ns4" 
 xmlns:ns5="http://example.com/ns5"
 ns2:someattribute="someattrvalue">
 somevalue<ns3:namespace3 
 xmlns:ns3="http://example.com/ns3" 
 ns2:someattribute="someattrvalue"/>
 <ns4:namespace4 xmlns:ns4="http://example.com/ns4"/><ns5:namespace5 
 xmlns:ns5="http://example.com/ns5"/>
 <ns5:namespace5 xmlns:ns5="http://example.com/ns5">namespace number five
 </ns5:namespace5><ns1:somenode>some value 2</ns1:somenode></ns1:somenode>
  
 Все в общем то правильно, но как видно из листинга , если элементы с одинаковыми неймспейсами вложены друг в друга
 то в том элементе который вложен - заново объявление xmlns:ns1="http://example.com/ns1" - пространства имен
 уже отсутсвует
 */

$data =  <<<XML
<?xml version="1.0"?>
<library xmlns="http://example.org/library"
xmlns:meta="http://example.org/book-meta"
xmlns:pub="http://example.org/publisher"
xmlns:foo="http://example.org/foo"
xmlns:jumbo="http://example.org/jumbo">
<book meta:isbn="0345342968">
<title>Fahrenheit 451</title>
<author>Ray Bradbury</author>
<bookshop>
    <shop_item xmlns:shops="http://example.org/shop">
        <shops:pushkina_boulevard>The world of book</shops:pushkina_boulevard>
    </shop_item>
</bookshop>
<pub:publisher>Del Rey</pub:publisher>
<foo:publisher>Juseppe Del Rey</foo:publisher>
</book>
</library>
XML;

$s_xml = new SimpleXMLElement($data);
// Импорт в DOM из SimpleXml
$dom_imported = dom_import_simplexml($s_xml); //DOMElement object

$dom = new DOMDocument(); // так - передать $dom_imported в конструктор не получилось - фатал
$r = $dom->importNode($dom_imported, true); //DOMElement object  - второй параметр true указывает что передается 
                                            // дерево с несколькими уровнями вложенности
$dom->appendChild($r); // в документации ошибка, сюда нужно как раз $r передавать а не $dom_imported
$xml_dom_str = $dom->saveXML(); // корректно 

$dom_node = new DOMDocument();
$dom_node->loadXML($data);
/// импорт в SimpleXml из DOM
$simple_xml_imported = simplexml_import_dom($dom_node); //SimpleXMLElement object 
$xml_simple_str = $simple_xml_imported->saveXML(); // корректно 
$xml_dom_str;

// SOAP и XML - RPC
// Главную мысль- которую я вынес из этой части - их вообще 2:
// 1) - если ты определяешь в wsdl определенные доступные методы, то работать с этими методами можно
// просто вызывая этот метод в клиенте как обычный php метод
// 2) - есть еще такая штука как режим отладки в SOAP. setTrace называется - по нему можно смотреть 
// заголовки запроса, ответа, разного рода служебную информацию

try{
    // ЗДЕСЬ ИДЕТ ЧИСТАЯ АСБТРАКЦИЯ,ОТЛАДКЕ НЕ ПОДЛЕЖАЩАЯ БЕЗ КЛЮЧА Google
    //TODO: если представится возможность - нужно погонять SOAP клиента на полигоне
    $scl = new SoapClient('http://api.google.com/GoogleSearch.wsdl');
    $r = $scl->doGoogleSearch($key, $query, 0, 10, FALSE, '', FALSE, '', '', ''); // - если этот метод определен
                                                                                  // в WSDL - в нашем случае определены
    foreach ($results->resultElements as $result){
        echo '<a href="'. htmlentities($result->URL) . '">'.
        htmlentities($result->title, ENT_COMPAT, 'UTF-8').'</a><br/>';
    }
}
catch(SoapFault $e){
    $msg = $e->getMessage();
}

// Режим отладки в SOAP клиенте
$client = new SoapClient('http://api.google.com/GoogleSearch.wsdl',
array('trace' => 1));
$results = $client->doGoogleSearch($key, $query, 0, 10, FALSE, '',
FALSE, '', '', '');
$headers_rec = $client->__getLastRequestHeaders();
$headers_rec = $client->__getLastRequest();


// Попробуем теперь с SOAP Server
class MySoapServer{
    
    public function getMessage()
    {
        return 'Hello wlrd';
    }
    
    public function addNumbers($n1, $n2)
    {
        return $n1 + $n2;
    }
}


/**
 *  Возможные варианты запуска (взято с php.net)
 * 
 *  $server = new SoapServer("some.wsdl");
    $server = new SoapServer("some.wsdl", array('soap_version' => SOAP_1_2));
    $server = new SoapServer("some.wsdl", array('actor' => "http://example.org/ts-tests/C"));
    $server = new SoapServer("some.wsdl", array('encoding'=>'ISO-8859-1'));
    $server = new SoapServer(null, array('uri' => "http://test-uri/"));

    class MyBook {
        public $title;
        public $author;
    }

    $server = new SoapServer("books.wsdl", array('classmap' => array('book' => "MyBook")));
   сейчас SOAP сервер автоматически не генерирует файл wsdl на основе класса, хотя в будущем, 
   говорят - будет
 */
/**
WSDL файл представляет собой обычный XML файл, часто с неймспейсами
 
Вот фрагмент wsdl файла (взят отсюда: http://www.rsdn.ru/forum/dotnet/1881615.1.aspx)
<?xml version="1.0" encoding="UTF-8"?>
<wsdl:definitions xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" 
 xmlns:tns="http://ws.EmForge.emdev.ru" 
 xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" 
 xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
 name="EmForge" 
 targetNamespace="http://ws.EmForge.emdev.ru">
    <wsdl:types>
    <xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        elementFormDefault="qualified"
        targetNamespace="http://ws.EmForge.emdev.ru" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
    <xsd:import namespace="http://schemas.xmlsoap.org/soap/encoding/"
        schemaLocation="http://schemas.xmlsoap.org/soap/encoding/">
    </xsd:import>
    <xsd:complexType name="TFilter">
        <xsd:sequence>
            <xsd:element name="temp" type="xsd:string"></xsd:element>
        </xsd:sequence>
    </xsd:complexType>
 */

// установка SOAP сервера
$ss = new SoapServer(null, array('encoding'=>'UTF-8', 'uri'=>'http://myspace.my/style'));
$ss->setClass('MySoapServer');
$ss->handle();// типа старт сервера Handles a SOAP request

// а теперь попробуем к нему доступиться
$options = array('location '=>'http://example.org/soap/server/server.php');
$client = new SoapClient(null, $options);
$first_method = $client->getMessage();
$second_method = $client->addNumbers(1, 2);

// НУ и на закуску типичный вариант REST запроса, хотя у них вообще общих правил никаких нет, 
// кроме того что кадждый ресурс должен быть предоставлен своим простым идентификатором
$u = 'username';
$p = 'password';
$fooTag = "https://{$u}:{$p}@api.del.icio.us/v1/posts/all?tag=foo";
$bookmarks = new SimpleXMLElement($fooTag, NULL, true);
foreach ($bookmarks->post as $bookmark){
    echo '<a href="' . htmlentities($bookmark['href']) . '">';
    echo htmlentities($bookmark['description']);
    echo "</a><br />\n";
}