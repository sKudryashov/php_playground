<?php
/**
 * xslt  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
// пример использования процессора

/**
$doc = new DOMDocument();
$xsl = new XSLTProcessor();

$doc->load($xsl_filename);
$xsl->importStyleSheet($doc);

$doc->load($xml_filename);
echo $xsl->transformToXML($doc);
 */

$xml = <<<XML
<?xml version="1.0"?>  
    
<summer>
    <month>June</month>
    <month>July</month>
    <month>August</month>
</summer>
XML;

$xsl = <<<XML
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    
<xsl:template match = "/">
    <html>
        <head>
            <title>Summer</title>            
        </head>
        <body>
            <xsl:apply-templates select="summer" />
        </body>
    </html>
</xsl:template>
<xsl:template match="summer">
    <table>
        <tr><xsl:apply-templates select="month" /></tr>
    </table>
</xsl:template>

<xsl:template match="month">
    <td><xsl:value-of select = "." /></td>
</xsl:template>

</xsl:stylesheet>
XML;
$dom_xml = new DOMDocument();
$dom_xml->loadXML($xml);

$dom_xsl = new DOMDocument();
$dom_xsl->loadXML($xsl);
$xslt = new XSLTProcessor();
$xslt->importStyleSheet($dom_xsl);
$xml =  $xslt->transformToXML($dom_xml);

$a = $xml;