<?php
// Dorothy Tran 101141902
  require_once('includes/config.inc.php');
  require_once('includes/art-classes.php');
  require_once('includes/sql-database.inc.php'); 
  
  $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
  if (!isset($_SESSION['favorites'])) {
    $favorites = array();
    $_SESSION['favorites'] = $favorites;
  }
  $favorites = $_SESSION['favorites'];
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

<section class="eleven wide column">
    <h1 class="ui header">Favourite Paintings</h1>
    <ul class="ui divided items" id="paintingsList">
        <?php 
        if (isset($_SESSION['favorites'])){
          $favorites = $_SESSION['favorites'];
          foreach($favorites as $favorite) {
              echo '<li class="item">
              <a class="ui small image" href="single-painting.php?id='. $favorite[0] . '"><img src="images/art/works/square-medium/'.$favorite[1].'.jpg"></a>
              <div class="content">
              <a class="header" href="single-painting.php?id=' . $favorite[0].'">'.$favorite[2].'</a>     
              <div class="extra">
                  <a class="ui icon button" href="remove-favorites.php?id='.$favorite[0].'">
                      Remove All Favourites
                  </a>
              </div>        
              </div>      
          </li>';
            } 
        }  
        ?>
    </ul>        
</section>  

