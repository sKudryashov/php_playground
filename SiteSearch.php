<?php
  namespace Search\Google;
  use Search\Google\Exceptions\SiteSearchException;
  /**
* Class to perform a search against against a Google Custom Search Engine and to process the resulting XML.
* @package Google Site Search
* @author Jeremy Cook
* @version 1.1
* @see http://www.google.com/sitesearch/
* @see http://www.google.com/cse/docs/resultsxml.html
*/
  class SiteSearch {
	  /**
	  * The url of the Google search API
	  * 
	  * @var string
	  */
	  protected $url = 'http://www.google.com/cse';
	  /**
	  * The CSE key (user id) provided by Google for the custom search engine.
	  * 
	  * @var string
	  */
	  protected $cseKey;
	  /**
	  * The client parameter. This is a value needed by Google ito process the API request. Currently this should always be google-csbe.
	  * 
	  * @var string
	  */
	  protected $clientParam = 'google-csbe';      
	  /**
	  * The method used to perform a http request to the webservice. Can either be cURL or streams (fopen).
	  * 
	  * @var string
	  */
	  protected $connMethod;
	  /**
	  * Flag to indicate how text results are to be processed.
	  * 
	  * @var int
	  */
	  protected $processText;
	  /**
	  * Associative array of extra values to be passed to Google as query string parameters
	  * 
	  * @var mixed
	  */
	  protected $opts = array();
	  /**
	  * Array of results from the search
	  * 
	  * @var array
	  */
	  protected $results = array();
	  /**
	  * Array of spelling suggestions from the search
	  * 
	  * @var array
	  */
	  protected $spellingSuggestions = array();
	  /**
	  * Character encoding to be used for the request and the response.
	  * 
	  * @var string
	  */
	  protected $charEncoding;
	  /**
	  * The query to be used to search google
	  * 
	  * @var string
	  */
	  protected $query;
	  /**
	  * Constants to indicate how text returned from Google should be processed.
	  * PLAIN_TEXT strips all HTML from the results and converts all HTML entities back to their characters.
	  * ENTITIES_ENCODED strips just the HTML but leaves the special characters entity encoded.
	  * HTML leaves the search results with the HTML from Google and with all special characters encoded.
	  */
	  const PLAIN_TEXT = 1;
	  const ENTITIES_ENCODED = 2;
	  const HTML = 3;
	  /**
	  * The constructor initialises the CSE key, sets extra parameters and determines the connection method to use.
	  * 
	  * @param string $cseKey User if for the custom index
	  * @param string $charEncoding Character encoding to use for the request and for converting the response to. Defaults to 'iso-8859-1'
	  * @param int $processText Flag to indicate how text should be processed. Can be set to 1, 2 or 3 (use class constants). Defaults to 1 (plain text).
	  * @param array $opts Optional associative array of extra values to send to Google as part of the query string. Key is the name of the parameter, value is what to set it to. See http://www.google.com/cse/docs/resultsxml.html#WebSearch_Query_Parameter_Definitions 
	  * @throws SiteSearchException
	  * @return GoogleSiteSearch
	  */
	  public function __construct ($cseKey, $charEncoding = 'iso-8859-1', $processText = SiteSearch::PLAIN_TEXT, array $opts = NULL) {       
		  //Set up the connection method
		  if (function_exists('curl_init')) {
			  $this->connMethod = 'curl';
		  } else if (ini_get('allow_url_fopen')) {
			  $this->connMethod = 'streams';
		  } else {
			  //Class needs either cURL or the http stream wrapper to work. Throw an exception.
			  throw new SiteSearchException('Neither cURL or http streams are available on this server', SiteSearchException::MISSING_PHP_EXTENSIONS);
		  }
		  //Set object properties
		  $this->cseKey = $cseKey;
		  $this->processText = $processText;
		  $this->opts = $opts;
		  $this->charEncoding = $charEncoding;
	  }
	  /**
	  * Getter to allow access to the search results
	  * 
	  * @param string $name
	  * @returns mixed
	  */
	  public function __get($name) {
		  switch ($name) {
			  case 'results':
			  case 'spellingSuggestions':
				return $this->$name;
			  default:
				return false;
		  }
	  }
	  /**
	  * Setter to allow parameters to be set. This is useful when multiple searches might need to be performed using one object.
	  * 
	  * @param string $name
	  * @param mixed $value
	  * @return bool
	  */
	  public function __set($name, $value) {
		  switch (true) {
			  case ($name === 'processText' && intval($value)):
				$this->processText = (int) $value;
				return true;
			  case ($name === 'opts' && is_array($value)):
			  case ($name === 'cseKey' && is_string($value)):
			  case ($name === 'charEncoding' && is_string($value)):
				$this->$name = $value;
				return true;
			  default:
				return false;
		  }
	  }
	  /**
	  * Public wrapper method to initiate a web service request
	  * 
	  * @param string $query The text to use in the search.
	  * @return void
	  */
	  public function query($query) {
		  $this->query = $query;
		  //Check the http interface being used and call the correct method to perform a request.
		  switch ($this->connMethod) {
			  case 'curl':
				$this->doCurlRequest();
				break;
			  case 'streams':
				$this->doFopenRequest();
				break;
		  }
	  }
	  /**
	  * Method to perform a cURL request to the API
	  * 
	  * @throws RuntimeException
	  * @return void
	  */
	  protected function doCurlRequest () {
		  if (! $ch = curl_init($this->buildUrl())) { 
			  //Error getting a cURL resource. Throw an exception.
			  throw new SiteSearchException('Unable to initialise cURL resource', SiteSearchException::CURL_ERROR);
		  }
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  $response = curl_exec($ch);
		  //Get information on the http request
		  $responseHeader = curl_getinfo($ch);
		  curl_close($ch);
		  if ($response === false) { 
			  //Error performing the HTTP request. Throw an exception.
			  throw new SiteSearchException('Unable to execute cURL HTTP request.', SiteSearchException::CURL_ERROR);
		  }
		  switch ($responseHeader['http_code']) {
			  case 200:
				//Successful API request. Process the response.
				$this->processResponse($response);
				break;
			  default:
				$this->processError((int) $responseHeader['http_code']);
				break;
		  }
	  }
	  /**
	  * Method to perform a request to the API using PHP's streams extension.
	  * 
	  * @throws SiteSearchException
	  * @return void
	  */
	  protected function doFopenRequest () {
		  //Build an array to create a stream context
		  $opts = array (
			'http' => array (
				'method' => 'GET',
				'ignore_errors' => true //Ensures that any XML generated by the service is fetched even if the HTTP status is a failure code. XML in this case might contain an error message
			)
		  );
		  $context = stream_context_create($opts);
		  $response = file_get_contents($this->buildUrl(), 0, $context);
		  if ($response === false) { 
			  //Error performing the HTTP request. Throw an exception.
			  throw new SiteSearchException('Unable to execute streams HTTP request.', SiteSearchException::STREAMS_ERROR);
		  }
		  //Get the HTTP status code. $http_response_header contains information about the status of the request.
		  preg_match('/\d{3,3}/', $http_response_header[0], $header);
		  switch ($header[0]) {
			  case '200'://Successful API request. Process the response.
				$this->processResponse($response);
				break;
			  default:
				$this->processError((int) $header[0]);
				break;
		  }
	  }
	  /**
	  * Method to build a request url with a fully url escaped query string
	  * 
	  * @return string
	  */
	  protected function buildUrl () {
		  //Required parameters for the service 
		  $params = array (
			'q' => $this->query, 
			'client' => $this->clientParam, 
			'output' => 'xml_no_dtd', //Recommended format for the XML from Google.
			'cx' => $this->cseKey,
			'ie' => $this->charEncoding, //Sets input character encoding for the search query
			'oe' => 'utf-8'//Get results back in UTF-8. Simple_XML outputs everything as utf-8 so we'll worry about converting character encoding later if need be.
		  );
		  //Merge the additional options with the querystring parameters if any set
		  if ($this->opts) {
			  $params = array_merge($params, $this->opts);
		  }
		  //Return the full url
		  return $this->url . '?' . http_build_query($params);
	  }
	  /**
	  * Method to process the response from Google and set the results as properties of the object
	  * 
	  * @param string $response The XML response from Google.
	  * @throws RuntimeException
	  * @return void
	  */
	  protected function processResponse ($response) {    
		  //Reset the results and spelling suggestions from any previous request.
		  if ($this->results) 
			$this->results = array();
		  if ($this->spellingSuggestions) 
			$this->spellingSuggestions = array();
		  //Load the response into Simple_XML
		  if (! $xml = simplexml_load_string($response)) {
			  throw new SiteSearchException('Unable to parse response into a Simple_XML object', SiteSearchException::BAD_XML_RESPONSE);
		  }
		  //Check for spelling suggestions from Google in case it thinks a search term was mis-spelt.
		  if ($xml->Spelling) {
			  foreach ($xml->Spelling->Suggestion as $suggestion) {
				  //Process the text
				  switch ($this->processText) {
					  case SiteSearch::PLAIN_TEXT:
						$suggestion = strip_tags(html_entity_decode($suggestion, ENT_QUOTES, 'utf-8'));
						break;
					  case SiteSearch::ENTITIES_ENCODED:
						$suggestion = strip_tags($suggestion);
						break;
					  case SiteSearch::HTML:
						$suggestion = (string) $suggestion;
						break;
				  }
				  //Convert the character encoding
				  if ('utf-8' !== strtolower($this->charEncoding)) {
					  $suggestion = iconv('utf-8', $this->charEncoding . '//TRANSLIT//IGNORE', $suggestion);
				  }
				  $this->spellingSuggestions[] = $suggestion;
			  }
		  }
		  //Loop through the results, setting them in the results array
		  if ($xml->RES) {
			   foreach ($xml->RES->R as $result) {
				   //Process the text
				   switch ($this->processText) {
					  case SiteSearch::PLAIN_TEXT:
					  case SiteSearch::ENTITIES_ENCODED:
						if ($this->processText === SiteSearch::PLAIN_TEXT) {
							$title = strip_tags(html_entity_decode($result->T, ENT_QUOTES, 'utf-8'));
							$text = strip_tags(html_entity_decode($result->S, ENT_QUOTES, 'utf-8'));
						} else if ($this->processText === SiteSearch::ENTITIES_ENCODED) {
							$title = strip_tags($result->T);
							$text = strip_tags($result->S);
						}
						//$result->T includes <br> elements. When these are stripped they leave extra spaces. Remove these.
						$text = preg_replace('/\s{2,}/', ' ', $text);
						break;
					  case SiteSearch::HTML:
						$title = (string) $result->T;
						$text = (string) $result->S;
						break;
				  }
				   $url = (string) $result->U;
				   $url_enc = (string) $result->UE;//url encoded version of the url
				   $lang = (string) $result->LANG;
				   //Convert the character encoding if needed
				   if ('utf-8' !== strtolower($this->charEncoding)) {
						//Convert to the requested character encoding. First try to translate characters into the new character set but if they can't ignore any untranslateable characters.
						$title = iconv('utf-8', $this->charEncoding . '//TRANSLIT//IGNORE', $title); 
						$text = iconv('utf-8', $this->charEncoding . '//TRANSLIT//IGNORE', $text);
						$url = iconv('utf-8', $this->charEncoding . '//TRANSLIT//IGNORE', $url);
						$url_enc = iconv('utf-8', $this->charEncoding . '//TRANSLIT//IGNORE', $url_enc);
						$lang = iconv('utf-8', $this->charEncoding . '//TRANSLIT//IGNORE', $lang);
				   }
				   $this->results[] = array(
												'title' => $title, 
												'url' => $url,
												'url_encoded' => $url_enc,
												'text' => $text,
												'lang' => $lang
											  );              
			  }
		  }
	  }
	  /**
	  * Method to handle an error response.
	  * 
	  * @param int $errorCode The HTTP response code from the API call.
	  * @throws RuntimeException
	  */
	  protected function processError ($errorCode) {
		  /**
		  * @todo Get a list of the different error codes and meanings from Google and make the message more descriptive.
		  */
		  $message = "API error. Google returned the following HTTP status code: $errorCode";
		  throw new SiteSearchException($message, SiteSearchException::API_ERROR, NULL, $errorCode);          
	  }
  }
?>