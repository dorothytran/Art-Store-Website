<?php
// Dorothy Tran 101141902
  require_once('includes/config.inc.php');
  require_once('includes/art-classes.php');
  require_once('includes/sql-database.inc.php'); 
  $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));

  // Initializations to retrieve the ID
  $artID = readSinglePainting($_GET["id"]);
  $genres = readPaintingGenre($_GET["id"]);
  $subjects = readPaintingSubject($_GET["id"]);
  $starReview = determineAverage($_GET["id"]);
  $reviews = readReviews($_GET["id"]);

  // Filter buttons
  $frames = readTypesFrame();
  $glasses = readTypesGlass();
  $matts = readTypesMatt();
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

<main >
    <!-- Main section about painting -->

    <?php  
        foreach ($artID as $art) {
    ?>
        <section class="ui segment grey100">
            <div class="ui doubling stackable grid container">
            
                <div class="nine wide column">
                <img src=<?php echo "images/art/works/medium/". $art["ImageFileName"].".jpg" ?> 
                    alt="..." 
                    class="ui big image" 
                    id="artwork">
                    
                    <div class="ui fullscreen modal">
                    <div class="image content">
                        <img src=<?php echo "images/art/works/large/" . $art["ImageFileName"] . ".jpg" ?> 
                          alt="..." 
                          class="image" >
                        <div class="description">
                        <p></p>
                        </div>
                    </div>
                    </div>                
                    
                </div>	<!-- END LEFT Picture Column --> 
                
                <div class="seven wide column">
                    
                    <!-- Main Info -->
                    <div class="item">
                    <?php
                    echo '<h2 class="header">'.$art["Title"].'</h2>
                              <h3>'.$art["FirstName"] . " " . $art["LastName"].'</h3>';
                    ?>
                        <div class="meta">
                            <p>
                            <?php
                              reviewOrangeStars(round($starReview), 0, 0);
                            ?>
                            </p>
                            <p><?php echo $art["Description"] ?></p>
                        </div>  
                    </div>                          
                    
                    <!-- Tabs For Details, Museum, Genre, Subjects -->
                    <div class="ui top attached tabular menu ">
                        <a class="active item" data-tab="details">
                            <i class="image icon"></i>Details
                        </a>
                        <a class="item" data-tab="museum">
                            <i class="university icon"></i>Museum
                        </a>
                        <a class="item" data-tab="genres">
                            <i class="theme icon"></i>Genres
                        </a>
                        <a class="item" data-tab="subjects">
                            <i class="cube icon"></i>Subjects
                        </a>    
                    </div>
                    
                    <div class="ui bottom attached active tab segment" data-tab="details">
                        <table class="ui definition very basic collapsing celled table">
                        <tbody>
                            <tr>
                                <td>
                                    Artist
                                </td>
                                <td>
                                    <a href="#"> 
                                        <?php echo $art["FirstName"] . " " . $art["LastName"] ?>
                                    </a>
                                </td>                       
                            </tr>
                            <tr>                       
                                <td>
                                    Year 
                                </td>
                                <td>
                                    <?php echo $art["YearOfWork"]?>
                                </td>
                            </tr>       
                            <tr>
                                <td>
                                    Medium
                                </td>
                                <td>
                                    <?php echo $art["Medium"]?>
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Dimensions
                                </td>
                                <td>
                                    <?php echo $art["Width"] . "cm x " . $art["Height"] . "cm"?>
                                </td>
                            </tr>        
                        </tbody>
                        </table>
                    </div>
                    
                    <div class="ui bottom attached tab segment" data-tab="museum">
                        <table class="ui definition very basic collapsing celled table">
                        <tbody>
                            <tr>
                            <td>
                                Museum
                            </td>
                            <td>
                                <?php echo $art["GalleryName"]?>
                            </td>
                            </tr>       
                            <tr>
                            <td>
                                Assession #
                            </td>
                            <td>
                                <?php echo $art["AccessionNumber"]?>
                            </td>
                            </tr>  
                            <tr>
                            <td>
                                Copyright
                            </td>
                            <td>
                                <?php echo $art["CopyrightText"]?>
                            </td>
                            </tr>       
                            <tr>
                            <td>
                                URL
                            </td>
                              <?php echo '<td><a href="'.$art['MuseumLink'].'">View painting at museum site</a></td>'; ?>
                            </tr>        
                        </tbody>
                        </table>    
                    </div>     
                    <div class="ui bottom attached tab segment" data-tab="genres">
    
                            <ul class="ui list">
                                <?php 
                                     foreach ($genres as $genre) {
                                        echo "<li class='item'><a href='#'> " . $genre["GenreName"] . " </a></li>" ; 
                                     }
                                ?>
                            </ul>

                    </div>  
                    <div class="ui bottom attached tab segment" data-tab="subjects">
                        <ul class="ui list">
                                <?php 
                                    foreach ($subjects as $subject) {
                                        echo "<li class='item'><a href='#'> " . $subject["SubjectName"] . " </a></li>" ;
                                    }
                                ?>
                            </ul>
                    </div>  
                    
                    <!-- Cart and Price -->
                    <div class="ui segment">
                        <div class="ui form">
                            <div class="ui tiny statistic">
                            <div class="value">
                                <?php echo "$" . number_format($art["Cost"], 0,'.',',') ?>
                            </div>
                            </div>
                            <div class="four fields">
                                <div class="three wide field">
                                    <label>Quantity</label>
                                    <input type="number">
                                </div>                               
                                <div class="four wide field">
                                    <label>Frame</label>
                                    <select id="frame" class="ui search dropdown">
                                      <option value="">None</option>
                                    <?php
                                      foreach($frames as $frame){
                                        echo '<option>'.$frame['Title'].'</option>';
                                      }
                                    ?>
                                    </select>
                                </div>  
                                <div class="four wide field">
                                    <label>Glass</label>
                                    <select id="glass" class="ui search dropdown">
                                    <option value="">None</option>
                                      <?php
                                        foreach($glasses as $glass){
                                        echo '<option>'.$glass['Title'].'</option>';
                                      }
                                      ?>
                                    </select>
                                </div>  
                                <div class="four wide field">
                                    <label>Matt</label>
                                    <select id="matt" class="ui search dropdown">
                                    <option value="">None</option>
                                      <?php
                                        foreach($matts as $matt){
                                        echo '<option>'.$matt['Title'].'</option>';
                                      }
                                      ?>
                                    </select>
                                </div>           
                            </div>                     
                        </div>

                        <div class="ui divider"></div>

                        <button class="ui labeled icon orange button">
                            <i class="add to cart icon"></i>
                                Add to Cart
                        </button>
                        <?php
                            echo '<a class="ui icon button" href="addToFavorites.php?id='.$art['PaintingID'].'">
                            <i class="heart icon"></i>
                            
                            Add to Favourites
                            </a>';    
                        ?>   
                        </div>        <!-- END Cart -->                                                 
                </div>	<!-- END RIGHT data Column --> 
            </div>		<!-- END Grid --> 
        </section>		<!-- END Main Section --> 
        
        <!-- Tabs for Description, On the Web, Reviews -->
        <section class="ui doubling stackable grid container">
            <div class="sixteen wide column">
            
                <div class="ui top attached tabular menu ">
                <a class="active item" data-tab="first">Description</a>
                <a class="item" data-tab="second">On the Web</a>
                <a class="item" data-tab="third">Reviews</a>
                </div>
                
                <div class="ui bottom attached active tab segment" data-tab="first">
                    <?php echo $art["Description"] ?>
                </div>	<!-- END DescriptionTab --> 
                
                <div class="ui bottom attached tab segment" data-tab="second">
                    <table class="ui definition very basic collapsing celled table">
                    <tbody>
                        <tr>
                            <td>
                                Wikipedia Link
                            </td>
                            <td>
                                <a href=<?php echo $art["WikiLink"]?>>View painting on Wikipedia</a>
                            </td>                       
                        </tr>                       
                        
                        <tr>
                            <td>
                                Google Link
                            </td>
                            <td>
                                <a href=<?php echo $art["GoogleLink"]?>>View painting on Google Art Project</a>
                            </td>                       
                        </tr>
                        
                        <tr>
                            <td>
                                Google Text
                            </td>
                            <td>
                                <?php echo $art["Description"]?>
                            </td>                       
                        </tr>                      
                    </tbody>
                    </table>
                </div>   <!-- END On the Web Tab --> 
                
                <div class="ui bottom attached tab segment" data-tab="third">                
                    <div class="ui feed">
                    <?php 
                        foreach($reviews as $review){ ?>
                          <div class="event">
                          <div class="content">
                            <div class="date"><?php echo date_format(date_create($review['ReviewDate']), "m/d/Y")?></div>
                            <div class="meta">
                              <a class="like">
                                <?php reviewStars($review['Rating']) ?>
                              </a>
                            </div>                    
                            <div class="summary">
                              <?php echo $review['Comment'] ?>
                            </div>       
                          </div>
                          </div>
                          <div class="ui divider"></div>
                      <?php  } ?>
                    </div>                                
                </div>   <!-- END Reviews Tab -->          
            
            </div>        
        </section> <!-- END Description, On the Web, Reviews Tabs --> 

    <?php  
        }
    ?>
    
    <!-- Related Images ... will implement this in assignment 2 -->    
    <section class="ui container">
    <h3 class="ui dividing header">Related Works</h3>        
	</section>  
	
</main>    
    

    
  <footer class="ui black inverted segment">
      <div class="ui container">footer</div>
  </footer>
</body>
</html>