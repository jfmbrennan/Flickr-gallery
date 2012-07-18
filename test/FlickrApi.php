<?php
/**
 * This is were we will write our tests before written our code
 *
 */

// Import Flickr Class
require_once('../libs/flickr.php');
 
class FlickrApi extends PHPUnit_Framework_TestCase
{

  /*
   * Test if we can connect to Flickr's API
   *
   */
  public function testFlickrApiRequest() {

    // Instantiate Flickr
    $flickr = new Flickr("00e8703723e5a0f290fe262c748cf4ff");

    $data = Array(
      'api_key' => '00e8703723e5a0f290fe262c748cf4ff',
      'method' => 'flickr.test.echo',
      'format' => 'php_serial'
    );

    // Try to connect to Flickr
    $response = $flickr->request($data);

    // Have we a valid response object?
    $this->assertNotNull($response);

    // Parse our response into a readable array format
    $parse_response = unserialize($response);

    // Did we succeed?
    $this->assertEquals($parse_response['stat'], 'ok');
  }
  /*
   * Test if we can connect to Flickr's API
   *
   */
  public function testFlickrApiPing() {

    // Instantiate Flickr
    $flickr = new Flickr("00e8703723e5a0f290fe262c748cf4ff");

    //Try to connect to Flickr
    $connect = $flickr->ping();

    // Did we succeed?
    $this->assertTrue($connect);
  }
  /*
   * Test if we can get images from Flickr
   *
   */
  public function testFlickrApiGetImages() {

    // Instantiate Flickr
    $flickr = new Flickr("00e8703723e5a0f290fe262c748cf4ff");

    // Try to connect to Flickr
    $response = $flickr->getImages("sydney");

    // Have we a valid response object?
    $this->assertNotNull($response);

    // Did we succeed?
    $this->assertEquals($response['stat'], 'ok');
  }
  /*
   * Test if we can connect to Flickr's API
   *
   */
  public function testFlickrApiGetImageURL() {

    // Instantiate Flickr
    $flickr = new Flickr("00e8703723e5a0f290fe262c748cf4ff");

    $image = array(
      'id'      =>  '7589014604',
      'farm'    =>  '9',
      'server'  =>  '8005',
      'secret'  =>  '20eb928ca2'
    );

    // Try to connect to Flickr
    $image_url = $flickr->getImageUrl($image);
    $url = 'http://9.staticflickr.com/8005/7589014604_20eb928ca2_q.jpg';

    // Did we succeed?
    $this->assertEquals($url, $image_url);
    
    // Try the same image, different size
    $image_url = $flickr->getImageUrl($image, 'm');
    $url = 'http://9.staticflickr.com/8005/7589014604_20eb928ca2_m.jpg';

    // Did we succeed?
    $this->assertEquals($url, $image_url);
  }
}
?>
