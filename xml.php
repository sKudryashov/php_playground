<?php
/**
 * xml  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */

/**
 * ��� ����� ����� - ����� ������� ������������ ��������� xml ��������, � ���
 * ������� � ���� � ��� � ��������. ������� ������� ����� ���� ���, �� ����
 * ����� ������������ ��� ���� - ��� ���� ����������, ������, � ��������
 * ��� ��������������� ����������, �.�. ����������. �� ��� ������ ����������
 * � ������� ������� ������������� ������ � ����� � ���� xml ���������
 *
 * ������� �� ���������� �������� �������, � ��� ��� library
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
 * Simple Xml � ������� ��� ��������� ������ XML 1.0 ������, ��� ������� 1.1 simpleXml ����� �����������
 * ��������, ��� � 5.3 - �� ����
 */

// ��� ������� ������. ������ ��� ������ �������� ��, ��� �� ������ ����� �����, 
// ����� ����� � ��������� � ���������. ���� ������� � Xpath, � ���� ������� � � 
// 
$vm = simplexml_load_string($data); // ��� ���� � �� �� ��� � ����������� ����
$s_xml = new SimpleXMLElement($data); // SimpleXMLElement object 
foreach($s_xml->book as $book){ //->SimpleXMLElement object
    $isbn = $book['isbn']->__toString();// �������  0345342968
    $title = $book->title->__toString(); // �������� Fahrenheit 451
    $author = $book->author->__toString(); // �������� R. Bradbury
    $publisher = $book->publisher; //SimpleXMLElement object {  CLASSNAME => (string) SimpleXMLElement }
}

//��� ����� ������� 
foreach ($s_xml->children() as $child){
    $childname = $child->getName();  // �������� book
    $attrs = $s_xml->attributes();   // �������� �������� ��� SimpleXmlElement
    
    foreach($child->children() as $ch){// ������ ������ � ����� ������� � ���������� ��� ��������
        $ch_name = $ch->getName();  // � ����� author publisher etc
        $attrs = $ch->attributes();
        $attrs_str = $attrs->__toString(); // 
    }    
}

// ����� � ��� ��� xpath �������� ������ � ������������ ����������, �� ���� ���� �� ��������� �� � 
// ����� � � �������� book �� � ����� ������� ��-��� book ������ �� �����. ������� DOM ������ ������
// ����� xpath() ���������� ������ ������ �������� SimpleXMLElement ���� ���� ������ ������ 1
$elbook = $s_xml->xpath('book'); //[0] => SimpleXMLElement object {
                                //    CLASSNAME => (string) SimpleXMLElement
                                //    @attributes => array(1) (
                                //      [isbn] => (string) 0345342968
                                //    )
                                //    title => (string) Fahrenheit 451
                                //    author => (string) R. Bradbury
                                //    publisher => (string) Del Rey
                                //  } � ��� �����...

foreach($elbook as $b){
    $el_name = $b; //SimpleXMLElement object
    $check = $el_name->__toString(); // ������ ������ �� ���� ���������
}

$eltitle = $s_xml->xpath('book/title'); //[0] => SimpleXMLElement object { CLASSNAME => (string) SimpleXMLElement }
foreach($eltitle as $title){
    echo $title;
    $check = $title->__toString(); //Fahrenheit 451 ... � ��� �����
}


$title_0 = $s_xml->book[0]->xpath('title'); //([0] => SimpleXMLElement object {CLASSNAME => (string) SimpleXMLElement } )
foreach ($title_0 as $t_0){
    $echo = $t_0->__toString; //SimpleXMLElement object
}

// �� �������� � ��������� ����� �� ���. ������ �� ��������������� xml ����������:,
// ������� � ������ 5.1.3 ���� ����������� ��������� �������� � xml
// ������:
$book = $s_xml->addChild('book'); // SimpleXMLElement object ������ ����� ����������� ��-�
$book->addAttribute('isbn', '01');
$book->addChild('author', 'Viktor Pelevin');
$book->addChild('title', 'generation_p');
$book->addChild('publisher', 'Ivan Nepomnyashiy');
header('Content-type: text/xml');
// ������ � asXML() ����� �������� ��� �����, � ���� ������ ���������������� xml ����� �������� � ���� �����
// ���� ����� �� ����������, ����� ������� ���, ���� ���� ���������� - ����� ����������� ��� ��� ������
// ��������� � ��������
// 
//echo $s_xml->asXML(); // � ��� ����� ��� XML
//
// �������� �������� �� ������ � simpleXml �������� ���: 
$s_xml->book[1] = NULL; // � ���� ������ ��� ��� ���� ������ �������� book ��������, �� ��� ������� ���������
// ����� �� ������� ��������� ��������, �� ����� � ���, ��� �� ����� ������ �������� �������, �� ��� ������� 
// ���� �� ��������. ������ ����� ������� ������ ��� � ���. ��� ����� ����������� �������� ��� 
// ���������� ����������� SimpleXml ������ � ������ DomDocument, ��� ����������� �� �������� ����� �������.


/* ������������ ���� � Xml */
// ��� ����� ������� ������� ��� ����, ����� �� ��������� ��������� ����
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

//getDocNamespaces ������ ��� ���������� ����������� � ���������
//getNamespaces ������ ��� ���������� ������������ � ���������
$dnss = $s_xml->getDocNamespaces();// ������ ��� ���������� ����������� � ���������, �������[]
                                    //array(5) (
                                    //  [] => (string) http://example.org/library
                                    //  [meta] => (string) http://example.org/book-meta
                                    //  [pub] => (string) http://example.org/publisher
                                    //  [foo] => (string) http://example.org/foo
                                    //  [jumbo] => (string) http://example.org/jumbo
                                    //)
$dnssr = $s_xml->getDocNamespaces(true); // � ���� ����, �� ���� �������� true �������� ����������� 
                                        // ���������, �.�. � ���� ������ � ����� ������� ���� �����
                                        // �.�.  � ������� ������� shops, � ���� �� �������� true, �� ��� �� �����. 
                                        //array(6) (
                                        //  [] => (string) http://example.org/library
                                        //  [meta] => (string) http://example.org/book-meta
                                        //  [pub] => (string) http://example.org/publisher
                                        //  [foo] => (string) http://example.org/foo
                                        //  [jumbo] => (string) http://example.org/jumbo
                                        //  [shops] => (string) http://example.org/shop
                                        //)
$nss = $s_xml->getNamespaces(); // ������ [] => (string) http://example.org/library �.�. ������ �����������
$nssr = $s_xml->getNamespaces(true);//������ ��� ������������ ���������� � ���� � � �������� ���������
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
//$str = $dom->loadHTMLFile('/xml/objects.html');// ��������� HTML ���� � DOM ������
$dom->save('library.xml'); //���������� � ����
$str = $dom->saveXML(); // ���������� � �������
$html = $dom->saveHTML(); // ���������� � HTML ������ ���� ��� ��������� ����� �� ����������
$dom->saveHTMLFile('library_html.xml'); // ���������� � HTML ����

// ������ ������������� ���������� ������ �������, ������� � ��� ������, � DOMDocument 
// ���� ����������� �������� � xpath ������� ����, ��� � simpleXml
//!! �� ����� �������� �������� ��� ������ � Xpath � DOM �������������� �����
// ��������� ������
$xpath = new DOMXPath($dom);

// ������������� - ����� ����� ���� �����������
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

$data_rss = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
<title>Neue Zürcher Zeitung - Schweiz</title>
<link>http://local.nzz.ch/aktuell/schweiz/</link>
<description>Schweiz</description>
<language>de-ch</language>
<copyright>Copyright ©Neue Zürcher Zeitung AG
Alle Rechte vorbehalten. Eine Weiterverarbeitung, Wiederveröffentlichung oder dauerhafte Speicherung
zu gewerblichen oder anderen Zwecken ohne vorherige ausdrückliche Erlaubnis von Neue Zürcher Zeitung ist nicht
gestattet.
</copyright>
<item>
<title>without Politische Uneinigkeit zur Wehrpflicht der Frauen111122</title>
<description></description>
<link>http://local.nzz.ch/aktuell/schweiz/without-politische-uneinigkeit-zur-wehrpflicht-der-frauen-1.18465301</link>
<guid isPermaLink="true">http://local.nzz.ch/1.18465301</guid>
<category>Schweiz</category>
<pubDate>Fri, 30 Aug 2013 16:06:00 +0200</pubDate>
</item>
<item>
<title>Europäischer Menschenrechtsgerichtshof: Strassburg fordert flexible Handhabung der Sanktionsliste</title>
<media:thumbnail url="http://www.foo.com/keyframe.jpg" width="75" height="50" time="12:05:01.123" />
<media:content width="145" height="145" link = "http://i.homer.nzzdali.ch/app.php/eos/v2/image/view/145/145/lead/outbound/0f57c4f2/1.17597219/1368709204/nada-campione-italia-carabinieri-original.gif" />
<media:category scheme="http://search.yahoo.com/mrss/category_ schema">music/artist/album/song</media:category>
<description>Die Schweiz hat die Freiheitsrechte des heute 81-jährigen Youssef Nada missachtet. Sie hatte den zu Unrecht als Bankier des Terrors verrufenen Geschäftsmann während Jahren in der italienischen Enklave Campione unter Arrest gestellt.</description>
<link>http://local.nzz.ch/aktuell/schweiz/schweiz-menschenrechte-konvention-verletzt-1.17597221</link>
<guid isPermaLink="true">http://local.nzz.ch/1.17597221</guid>
<category>Schweiz</category>
<pubDate>Fri, 02 Aug 2013 08:29:00 +0200</pubDate>
</item>
</channel>
</rss>
XML;

$domDocRSS = new \DOMDocument();
$domDocRSS->loadXML($data_rss);

$savedXml = $domDocRSS->saveXML();
$domDocRSSXPath = new \DOMXPath($domDocRSS);
$domDocRSSXPath->registerNamespace('media', 'http://search.yahoo.com/mrss/');
$dataRssTitle = $domDocRSSXPath->query('//title');
$dataRssCategory = $domDocRSSXPath->query('//media:category');
$dataRssThumbnail = $domDocRSSXPath->query('//media:thumbnail');

// ���� � ������������� ��� ������� - ����������� ����������, � ������������ � 
// ������ $data  ����� ���������� ��������� xmlns="http://example.org/library"
// �� xpath ����� �������� �������� � ��� ����������� ����������. 
// ���� �� � � $data �� ����� �������, xmlns="http://example.org/library" 
// � $xpath->registerNamespace �������������, �� ��������� $xpath->query("//title/text()");
// ������ �� ������. ������ ����� 'lib' ����� ��������� ������ ���� ������� ��� ����������
// ����������� �������� � ������ ����� ����������, ���� //lib:title/text()
$xpath->registerNamespace('lib', 'http://example.org/library'); // ����������� ����������� ������������� 
                                                                // ��� Xpath ������� � ��� ������ ���
                                                                // ����� ����� ����������� ������ � ����������
                                                                // http://example.org/library - 
                                                                // � lib ��� ��� ����� - ������� �� ��������� 
                                                                // ������ � ��������� ������� Xpath ��� ��� 
                                                                // ������������� � ������ query() ��� lib://lib:title
                                                                // � ���� ������ ��, ����� ����� ��������� ������ 
                                                                // � ���������� http://example.org/library                                                          // Xpath - 
$result_title_namespace = $xpath->query("//pub:publisher");

$result = $xpath->query("//lib:title/text()"); //����� �� ����� ����� ������ ���� title DOMNodeList
$result_title = $xpath->query("//lib:title");  // ����� ���������� �� ������� ��� ��� title DOMNodeList
                                               //(�� ����� �� ������ � ������ �� ������� ���)
$result_data = $result->item(0)->data; // �������� �������� ��� �������������� ������ � ��������

// ��������� �� ����������� � ��������� ��������� � ����� 
foreach($result as $i => $r){
    $data = $r->data; // ������ ������ Fahrenheit 451 - �� ���� ������ ���������� $r - DOMText- ���������  
    $wholeText = $r->wholeText; // ������ ������ Fahrenheit 451 - ���������� alias ��� data
}

foreach($result_title as $i => $r){
    $data = $r->data; // ������ null? �������, ���������� DOMElement �� ����� �������� data?
                      // �������� ������ http://tr2.php.net/manual/en/class.domelement.php
    $tagName = $r->tagName; // ��� �� ���� ��������, ������� ������ ��� ���� - ������ title
}
$result_without_text = $result_title->item(0)->data; // ������ null ��������� item(0) ������ ��� ��������� DOMElement
$result_title_data = $result_title->item(0)->tagName; // ������ ��� ���� title

if($result->length > 0){    
    $book = $result->item(0); //DOMText object
    echo $book->data;
    $_data = $book->data; // Fahrenheit 451
    
    foreach ($result as $res){ //$result - DOMNodeList object, $res - DOMText object
        $data_xpath = $res->data; // Fahrenheit 451
    }
}

// �������� ��������� DOM
$book = $dom->createElement('book'); //DOMElement object
$book->setAttribute('meta:isbn', '099292939');

// �������� �������� DomDocument � ������ � ��� 
$title = $dom->createElement('title'); //DOMElement object
$text = $dom->createTextNode('"php|architect�s Guide to PHP Design Patterns"'); //DOMText object
//$title->setAttribute('attr', 'we love you');
$title->setAttributeNS('http://something.com/ns1',
                        'ns1:mynamespace',
                        'jjjj'); 
                        // �������� ������ ������  � ����� ������� 
                        // <title xmlns:ns1="http://something.com/ns1" ns1:mynamespace="jjjj"> � ���� ���
                        // ��� ���������. �������� ����� ��� � ��� ��� � ������� ��������� ������� ������������ 
                        // ����� ��� xmlns (������ ns1) If the attribute does not exist, it will be created. 
$title->appendChild($text);
$book->appendChild($title);
$dom->documentElement->appendChild($book); // ��������� ��� ������� � ������
// ��������� ������������� ���������� ����� �������� -��� ����� ���� ��� ������ ���, ��� ����� �������� ��� ���
// � ������ DOM ������ ��� ������� � �������
$_xml_str = $dom->saveXML();
$_html_str = $dom->saveHTML();

$author = $dom->createElement('author', 'Jason E. Sweat');
// ������ ��� �������� ����� - ���������� ������� ���������� � ������� ��� ��������: ���������, ��� � ������
//<author xmlns:mynamespace="example.com/mynamespace" mynamespace:something="value">

$author->setAttributeNS('example.com/mynamespace', 'mynamespace:something','value');
$book->appendChild($author);

$publisher = $dom->createElement('pub:publisher','"Marco Tabini &amp; Associates, Inc."');
$book->appendChild($publisher);
$dom->documentElement->appendChild($book);
$_xml_str = $dom->saveXML();

$_html_str = $dom->saveHTML(); // 

// ������� ��������� DOM 
$dom = new DOMDocument();
$dom->loadXML($_xml_str);

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('lib', 'http://example.org/library'); // ������������ ���������
$result = $xpath->query('//lib:book'); // � ������� ��� ���� book ������� ��� �������������, ������ lib - ��� ����� ������
                                        //� ��������� ������� xpath - � �� � ��������� ���������
// �������� �� ��� � ��� ��� �������
foreach($result as $r){
    $item = $r->tagName;    // ������ book
}

$result = $xpath->query('//lib:book/text()'); // � ����� ������ ���� book

foreach($result as $r){
    $data = $r->data; //������ �� ������ ������ ��� ������ ������ ����
    $txt = $r->wholeText;   // ��� �����
    //
    //1)$item_data = $r->item(0)->data;//
    //2)$hz = $r->item(0)->hasChildNodes(); ��������� �� � [path ������� ��������� ������ text() �� ������� ��� � ���� 
    //�� ��� ���� ���������� ��� � ����� ���� 1 � 2 - �������� ������    
}

$result->item(0)->parentNode->appendChild($result->item(0));
// ������ appendChild � insertBefore - ���������� �������� DOM
// ���� ����� ��������������, �� ���� ����� ����� cloneNode()
$item1 = $result->item(1);
$clone = $item1->cloneNode();
$clone->insertBefore($result->item(0));
$saved_changed_xml = $dom->saveXML();

// ������ ��������� ��������� DOM 
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
$t1->data = ucwords($t1->data); // �� ���� ������ ������ ������ ����� ����������
$save = $dom->saveXML();

// ������ �������� ������ � DOM
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

// !!����� ������ �������� ���������� � query - ��� ��������, � ������� ����� ����������� �������� 
$result = $xpath->query('text()', $result->item(2)); //������ some more text here

// ����� �� ��������� ��� �������� ������ ��������, � �������� �������� �������� � ����� ���������� �������
$result->item(0)->deleteData(0, $result->item(0)->length); //� ���� ������ �� ������ ���. �� ����� � ��������� ���� ����
$saved = $dom->saveXML(); //<xml><text>some more text here</text><text type="misc"></text></xml>
$saved_htm = $dom->saveHTML();

// �������� ���������� � DOM
$dom = new DOMDocument();
// ��� ����� ������ ������� ������������� - ����� ������� 
$node = $dom->createElement('ns1:somenode');
$node->setAttribute('ns2:comeattribute', 'somevalue');
$node2 = $dom->createElement('ns3:somenode');
$node2->setAttribute('ns4:someattr', 'somev');
$node->appendChild($node2);
$node->setAttribute('xmlns:ns1', 'http://example.com/ns1');
$node->setAttribute('xmlns:ns2', 'http://example.com/ns2');
$node->setAttribute('xmlns:ns3', 'http://example.com/ns3');
$dom->appendChild($node); // !!! �� ��. ��� ����� ������� append child � dom ������ ��������� ��������
$xmlstr = $dom->saveXML();//<?xml version="1.0"���� �������>
                            //<ns1:somenode ns2:comeattribute="somevalue" 
                            //xmlns:ns1="http://example.com/ns1" 
                            //xmlns:ns2="http://example.com/ns2" 
                            //xmlns:ns3="http://example.com/ns3">
                            //  <ns3:somenode ns4:someattr="somev"/>
                            //  </ns1:somenode>

// � ���� ��� ���� ����� ����������� 
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
  
 ��� � ����� �� ���������, �� ��� ����� �� �������� , ���� �������� � ����������� ������������ ������� ���� � �����
 �� � ��� �������� ������� ������ - ������ ���������� xmlns:ns1="http://example.com/ns1" - ������������ ����
 ��� ����������
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
// ������ � DOM �� SimpleXml
$dom_imported = dom_import_simplexml($s_xml); //DOMElement object

$dom = new DOMDocument(); // ��� - �������� $dom_imported � ����������� �� ���������� - �����
$r = $dom->importNode($dom_imported, true); //DOMElement object  - ������ �������� true ��������� ��� ���������� 
                                            // ������ � ����������� �������� �����������
$dom->appendChild($r); // � ������������ ������, ���� ����� ��� ��� $r ���������� � �� $dom_imported
$xml_dom_str = $dom->saveXML(); // ��������� 

$dom_node = new DOMDocument();
$dom_node->loadXML($data);
/// ������ � SimpleXml �� DOM
$simple_xml_imported = simplexml_import_dom($dom_node); //SimpleXMLElement object 
$xml_simple_str = $simple_xml_imported->saveXML(); // ��������� 
$xml_dom_str;

// SOAP � XML - RPC
// ������� �����- ������� � ����� �� ���� ����� - �� ������ 2:
// 1) - ���� �� ����������� � wsdl ������������ ��������� ������, �� �������� � ����� �������� �����
// ������ ������� ���� ����� � ������� ��� ������� php �����
// 2) - ���� ��� ����� ����� ��� ����� ������� � SOAP. setTrace ���������� - �� ���� ����� �������� 
// ��������� �������, ������, ������� ���� ��������� ����������

try{
    // ����� ���� ������ ����������,������� �� ���������� ��� ����� Google
    //TODO: ���� ������������ ����������� - ����� �������� SOAP ������� �� ��������
    $scl = new SoapClient('http://api.google.com/GoogleSearch.wsdl');
    $r = $scl->doGoogleSearch($key, $query, 0, 10, FALSE, '', FALSE, '', '', ''); // - ���� ���� ����� ���������
                                                                                  // � WSDL - � ����� ������ ����������
    foreach ($results->resultElements as $result){
        echo '<a href="'. htmlentities($result->URL) . '">'.
        htmlentities($result->title, ENT_COMPAT, 'UTF-8').'</a><br/>';
    }
}
catch(SoapFault $e){
    $msg = $e->getMessage();
}

// ����� ������� � SOAP �������
$client = new SoapClient('http://api.google.com/GoogleSearch.wsdl',
array('trace' => 1));
$results = $client->doGoogleSearch($key, $query, 0, 10, FALSE, '',
FALSE, '', '', '');
$headers_rec = $client->__getLastRequestHeaders();
$headers_rec = $client->__getLastRequest();


// ��������� ������ � SOAP Server
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
 *  ��������� �������� ������� (����� � php.net)
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
   ������ SOAP ������ ������������� �� ���������� ���� wsdl �� ������ ������, ���� � �������, 
   ������� - �����
 */
/**
WSDL ���� ������������ ����� ������� XML ����, ����� � ������������
 
��� �������� wsdl ����� (���� ������: http://www.rsdn.ru/forum/dotnet/1881615.1.aspx)
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

// ��������� SOAP �������
$ss = new SoapServer(null, array('encoding'=>'UTF-8', 'uri'=>'http://myspace.my/style'));
$ss->setClass('MySoapServer');
$ss->handle();// ���� ����� ������� Handles a SOAP request

// � ������ ��������� � ���� �����������
$options = array('location '=>'http://example.org/soap/server/server.php');
$client = new SoapClient(null, $options);
$first_method = $client->getMessage();
$second_method = $client->addNumbers(1, 2);

// �� � �� ������� �������� ������� REST �������, ���� � ��� ������ ����� ������ ������� ���, 
// ����� ���� ��� ������� ������ ������ ���� ������������ ����� ������� ���������������
$u = 'username';
$p = 'password';
$fooTag = "https://{$u}:{$p}@api.del.icio.us/v1/posts/all?tag=foo";
$bookmarks = new SimpleXMLElement($fooTag, NULL, true);
foreach ($bookmarks->post as $bookmark){
    echo '<a href="' . htmlentities($bookmark['href']) . '">';
    echo htmlentities($bookmark['description']);
    echo "</a><br />\n";
}