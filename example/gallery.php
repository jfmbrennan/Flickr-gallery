<?php
/**
 * We will handle our posted form data here
 *
 */

require_once('../libs/flickr.php');
$flickr = new Flickr("api_key");

$search = $_POST['search']['query'];

$results = $flickr->getImages($search);


?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <!-- Import stylesheets first -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Import modernizr -->
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>

  <div id="page_container">
    <header id="page_header">
      <h1>PHP/HTML Flickr Gallery</h1>
    </header>

    <section id="page_section">
      <?php if(!empty($results) and is_array($results)) { ?>
        <ul id="gallery">
          <?php foreach($results as $photo) { ?>
            <li><?php echo $photo['id']; ?></li>
          <?php } ?>
        </ul>
      <?php } ?>
    </section>

    <footer id="page_footer"></footer>
  </div>

</body>
</html>
