<?php
/**
 * This will be where our flickr API code will be written
 *
 */

class Flickr {
  // Class variables
  var $api_key = null;
  var $endpoint = 'http://api.flickr.com/services/rest/';
  var $format = 'php_serial';

  /*
   * Our constructor
   */
  function Flickr($api_key)
  {
    $this->api_key = $api_key;
  }

  /*
   * This is where we post our request to the Flickr API
   *
   * @url http://php.net/manual/en/ref.curl.php
   *
   * @params mixed $data 
   * @return boolean|mixed False on failure, response data on success
   */
  function request($data) {

    // Initialise our cURL call
    $curl = curl_init();

    // Set our cURL options (url, post data)
    curl_setopt($curl, CURLOPT_URL, $this->endpoint);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


    // Execute the cURL request
    $content = curl_exec($curl);

    // Check if our 
    $response = curl_getinfo($curl);

    // Close the cURL request
    curl_close($curl); 

    // Did we get the response code that was expected?
    if ($response['http_code'] !== 200) {
      return false;
    }

    // And return the valid response
    return $response;
  }

  /*
   * A test function to see if Flickr is accepting REST requests
   *
   * @url http://www.flickr.com/services/api/flickr.test.null.html
   *
   * @return boolean true on success, false on failure
   */
  function ping() {

    // Build request data
    $data = array(
      'api_key' =>  $this->api_key,
      'format'  =>  $this->format,
      'method'  =>  'flickr.test.null',
    );

    // Make call to flickr.test.null
    $response = $this->request($data);

    // Only interested if a successful request was completed
    return ($response === false) ? false : true;
  }

  /*
   * Build query to search for images, parsing the response so
   * the view can easily fetch these images
   *
   * @url
   *
   * @params string $search_string 
   * @params integer $page Page number 
   * @params integer $limit How many image to get at a time
   * @return mixed Array of image data
   */
  function getImages($search_string="", $page=1, $limit=5) {
    // Build request data
    $data = array(
      'api_key'   =>  $this->api_key,
      'format'    =>  $this->format,
      'method'    =>  'flickr.photos.search',
      'text'      =>  $search_string,
      'page'      =>  $page,
      'per_page'  =>  $limit
    );

    // Make call to flickr.photos.search
    $response = $this->request($data);

    if($response === false) {
      return array();
    }

    // Return a parsed PHP array
    return unserialize($response);
  }

  /*
   * Build the URL that can be used to grab the image on demand
   *
   * @url http://www.flickr.com/services/api/misc.urls.html
   *
   * @params mixed $image The image to build the URL for
   * @params string $size Image size to retrieve 
   * @return string URL to fetch the image
   */
  function getImageURL($image, $size='q') {
    return "http://{$image['farm']}.staticflickr.com/{$image['server']}/{$image['id']}_{$image['secret']}_$size.jpg";
  }

}
?>
