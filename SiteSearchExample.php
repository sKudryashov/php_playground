<?php
use Search\Google,
    Search\Google\Exceptions;
  try {
      //A simple example, default parameters in constructor and no extra parameters set.
      $search = new SiteSearch('CSE Key Here');
      $search->query('some search text');
      //The results property contains the search results, spellingSuggestions contains any spelling suggestions from Google.
      var_dump($search->results);
      var_dump($search->spellingSuggestions);

      //Example with results returned with HTML from Google left in and character encoding set to UTF-16. Result text will also be encoded in UTF-16
      //NOTE: When using a custom character encoding the search query must also be encoded using this character set.
      //The object defaults to character encoding in iso-8859-1 and assumes that queries passed to it are also encoded in this character set.
      $search = new SiteSearch('CSE Key Here', 'utf-16', GoogleCustomSearch::HTML);
      $search->query('some search text');
      var_dump($search->results);
      var_dump($search->spellingSuggestions);

      //Use the same object to perform an extra search, but with some different parameters
      $search->charEncoding = 'iso-8859-1';
      $search->processText = GoogleCustomSearch::ENTITIES_ENCODED; //Strips HTML but leaves HTML special characters entity encoded.
      $search->query('another query');
      var_dump($search->results);
      var_dump($search->spellingSuggestions);

      //Example using an array to set extra, custom options in the query string used to send a request to Google.
      //See http://www.google.com/cse/docs/resultsxml.html#WebSearch_Query_Parameter_Definitions for a full list of query parameter options that may be passed in the request.
      $opts = array(
          'lr' => 'lang_fr', //Request search results only for French language pages.
          'cr' => 'countryCA', //Request search results only for a particular country, in this case Canada
          'num' => 7 //Limit the search to a maximum of 7 results
      );
      //Create an object using default search options
      $search = new SiteSearch('CSE Key Here');
      //Set the custom options for the search.
      //These can also be set by passing the $opts array as the final argument in the object constructor.
      $search->opts = $opts;
      $search->query('yet another query');
      var_dump($search->results);
      var_dump($search->spellingSuggestions);
  }
  catch (SiteSearchException $e) {
      //Handle any exceptions raised by the object here.
      echo $e->getMessage();
  }
?>