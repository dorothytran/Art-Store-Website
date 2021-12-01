<?php
// Dorothy Tran 101141902
    require_once('includes/config.inc.php');
    require_once('includes/art-classes.php');
    require_once('includes/sql-database.inc.php'); 
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));

    // Filter buttons
    $artists = readAllArtists();
    $museums = readAllMuseums();
    $shapes = readAllShapes();
    
    // Memcache connection creation
    $memcache = new Memcache;
    $memcache->connect('localhost', 11211) 
      or die ("Could not connect");
    
    $cacheArtistKey = 'artist';
    $cacheMuseumKey = 'gallery';
    $cacheShapeKey = 'shape';
    $cachePaintingKey = 'painting';

    $artistCache = $memcache->get($cacheArtistKey);
    $museumCache = $memcache->get($cacheMuseumKey);
    $shapeCache = $memcache->get($cacheShapeKey);
    $paintingCache = $memcache->get($cachePaintingKey);

    if(!$artistCache) {
      $artistCache = readAllArtists()->fetchAll();
      $memcache->set($cacheArtistKey, $artistCache, false, 240);
    }
    if(!$museumCache) {
      $museumCache = readAllMuseums()->fetchAll();  
      $memcache->set($cacheMuseumKey, $museumCache, false, 240);
    }
    if(!$shapeCache) {
      $shapeCache = readAllShapes()->fetchAll(); 
      $memcache->set($cacheShapeKey, $museumCache, false, 240);
    }

    if(!$paintingCache) {
      if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist']) && !empty($_GET['artist'])) {
        $paintings = readArtists($_GET["artist"])->fetchAll();  
      }
      else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['museum']) && !empty($_GET['museum']) ) {
        $paintings = readMuseums($_GET["museum"])->fetchAll();  
      }
      else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['shape']) && !empty($_GET['shape']) ) {
        $paintings = readShapes($_GET["shape"])->fetchAll();  
      }
      else {
        $paintings = readAllPaintings()->fetchAll();    
      }
      $memcache->set($cachePaintingKey, $paintingCache, false, 240);
    }
?>

<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
	<script src="js/misc.js"></script>
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">   
</head>
<body>

<?php include 'includes/header.inc.php'; ?>

<main class="ui segment doubling stackable grid container">
    <section class="five wide column">
        <form class="ui form" method='GET'>
          <h4 class="ui dividing header">Filters</h4>
          <div class="field">
            <label>Artist</label>
            <select name="artist" class="ui fluid dropdown">
                <option value="">Select Artist</option>  
                <?php 
                  foreach($artists as $artist) {
                      echo "<option value=".$artist['ArtistID'] .">".$artist['LastName'].", " . $artist['FirstName'] . "</option>";
                  }
                ?>
            </select>
          </div>  
          <div class="field">
            <label>Museum</label>
            <select name="museum" class="ui fluid dropdown">
                <option value="">Select Museum</option>  
                <?php 
                  foreach($museums as $museum) {
                    echo "<option value=".$museum['GalleryID'] .">".$museum['GalleryName'] . "</option>";
                  }
                ?>
            </select>
          </div>   
          <div class="field">
            <label>Shape</label>
            <select name="shape" class="ui fluid dropdown" name="shape">
                <option value="">Select Shape</option>  
                <?php 
                  foreach($shapes as $shape) {
                    echo "<option value=".$shape['ShapeID'] .">".$shape['ShapeName'] . "</option>";
                  }
                ?>
            </select>
          </div>   
            <button class="small ui orange button" type="submit">
              <i class="filter icon"></i> Filter 
            </button>    
        </form>
    </section>
    <section class="eleven wide column">
        <h1 class="ui header">Paintings</h1>
        <h5>All Paintings [Top 20]</h5>
        <ul class="ui divided items" id="paintingsList">
        <?php 
        /*if ($_SERVER["REQUEST_METHOD"] == "GET"){
            if (isset($_GET['id']) && isset($_GET["artist"]) && isset($_GET["museum"]) && isset($_GET["shape"])){
              
                $paintingCache = $memcache->get($cachePaintingKey);
                $cachePaintingKey = $_GET(['id']) .'_'. $_GET(['artist']) .'_'.$_GET(['museum']). '_'.$_GET(['shape']);
              $paintingCache = $memcache->get($cachePaintingKey);
              if(!$paintingCache) {
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist']) && !empty($_GET['artist'])) {
                  $paintings = readArtists($_GET["artist"]);  
                }
                else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['museum']) && !empty($_GET['museum']) ) {
                  $paintings = readMuseums($_GET["museum"]);  
                }
                else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['shape']) && !empty($_GET['shape']) ) {
                  $paintings = readShapes($_GET["shape"]);  
                }
                else {
                  $paintings = readAllPaintings();    
                }
                $memcache->set($cachePaintingKey, $paintingCache, false, 240);
              }
            } 
          }*/
          
          foreach($paintings as $painting) {
              echo '<li class="item">
              <a class="ui small image" href="single-painting.php?id='.$painting['PaintingID'].'"><img src="images/art/works/square-medium/'.$painting['ImageFileName'].'.jpg"></a>
              <div class="content">
                <a class="header" href="single-painting.php?id='.$painting['PaintingID'].'">'.$painting['Title'].'</a>
                <div class="meta"><span class="cinema">'.$painting['LastName'].'</span></div>        
                <div class="description">
                  <p>'.$painting['Excerpt'].'</p>
                </div>
                <div class="meta">     
                    <strong>$'.number_format($painting['MSRP'], 0,'.',',').'</strong>        
                </div>' . '        
                <div class="extra">
                  <a class="ui icon orange button" href="cart.php?id='.$painting['PaintingID'].'"><i class="add to cart icon"></i></a>  
                  <a class="ui icon button" href="addToFavorites.php?id=' .$painting['PaintingID']. '&file=' . $painting['ImageFileName'] . '&title=' . $painting['Title']. '"><i class="heart icon"></i></a>   
                  </div>        
              </div>      
            </li>';
            } ?>
        </ul>        
    </section>  
</main>    
  <footer class="ui black inverted segment">
      <div class="ui container">footer for later</div>
  </footer>
</body>
</html>