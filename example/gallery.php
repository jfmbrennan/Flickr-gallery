<?php
/**
 * We will handle our posted form data here
 *
 */

require_once('../libs/flickr.php');
$flickr = new Flickr("00e8703723e5a0f290fe262c748cf4ff");

$search = $_GET['q'];
$page = (empty($_GET['page'])) ? 1 : $_GET['page'];;

$results = $flickr->getImages($search, $page);
$pages = $results['photos']['pages'];

$page_range = array();

if($pages <= 10) { 
  $page_range = range(1, $pages);
} elseif($page <= 5) { 
  $page_range = range(1, 10);
} elseif (($pages-$page) < 5) {
  $page_range = range($pages-10, $pages);
} else {
  $page_range = range($page-5, $page+5);
}

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
    <header id="page_header" class="hero-unit">
      <h1>PHP/HTML Flickr Gallery</h1>
    </header>

    <section id="page_section">
      <?php if(!empty($results) and is_array($results)) { ?>
        <ul id="gallery" class="thumbnails">
          <?php foreach($results['photos']['photo'] as $photo) { ?>
            <li class="span3">
              <a class="thumbnail" href="<?php echo $flickr->getOriginalImageUrl($photo); ?>">
              <img src="<?php echo $flickr->getImageUrl($photo); ?>" title="<?php echo $photo['title']; ?>"/>
              </a>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>
      <div class="pagination pagination-centered">
        <ul>
          <?php if($page > 1) { ?>
            <li><a href="<?php echo "gallery.php?q=$search&page=".$page-1; ?>">Prev</a></li>
          <?php } ?>
          <?php foreach($page_range as $pg) { ?>
            <li<?php echo ($pg == $page) ? ' class="active"' : ''; ?>>
              <a href="<?php echo "gallery.php?q=$search&page=$pg"; ?>"><?php echo $pg; ?></a>
            </li>
          <?php } ?>
          <?php if($page != $pages) { ?>
            <li><a href="<?php echo 'gallery.php?q='.$search.'&page='.($page+1); ?>">Next</a></li>
          <?php } ?>
        </ul>
      </div>
    </section>

    <footer id="page_footer"></footer>
  </div>

</body>
</html>
