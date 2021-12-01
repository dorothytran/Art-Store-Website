<?php
// Dorothy Tran 101141902
    require_once('includes/config.inc.php');
    require_once('includes/art-classes.php');
    require_once('includes/sql-database.inc.php'); 
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS)); 

    if (isset($_GET['id']) && ! empty($_GET['id'])) {
        if (! isset($_SESSION['favorites'])) {
            $favorites = array();
            $favorites = $_SESSION['favorites'];
        }
        $favorites = $_SESSION['favorites'];
        $favorites[] = array($_GET["id"], $_GET["file"], $_GET["title"]);
        $_SESSION['favorites'] = $favorites;
    }
    header("Location: view-favorites.php");
?>