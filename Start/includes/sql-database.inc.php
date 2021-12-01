<?php
// Dorothy Tran 101141902

/* Connect to the MySQL database */
function setConnectionInfo($values=array()) {
    try {
        $pdo = new PDO($values[0], $values[1], $values[2]);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
    return $pdo;  
}

/* Function to run the query (from Lab 5) */
function runQuery($pdo, $sql, $parameters=array()) {
    $statement = $pdo->prepare($sql);
    $statement->execute($parameters);
    return $statement;
}

/* Function that retrieves all artists from the Artists table */
function readAllArtists() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM artists ORDER BY LastName";
    $statement = runQuery($pdo, $sql, array());
    return $statement;
} 

/* Function retrieves all museums/galleries from the galleries table */
function readAllMuseums() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM galleries ORDER BY GalleryName";
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}

/* Function that retrieves all shapes from the Artists table */
function readAllShapes() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM shapes ORDER BY ShapeName";
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}

/* Function that retrieves all paintings from the Paintings, Artists and Galleries table */
function readAllPaintings() {
    $sql = "SELECT * FROM paintings INNER JOIN artists ON (paintings.ArtistID = artists.ArtistID) INNER JOIN galleries ON (paintings.GalleryID = galleries.GalleryID) ORDER BY YearOfWork LIMIT 20";
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}

/* Function that retrieves all artists by ID */
function readArtists($id) {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM paintings INNER JOIN artists ON (paintings.ArtistID = artists.ArtistID) INNER JOIN galleries ON (paintings.GalleryID = galleries.GalleryID) WHERE paintings.ArtistID = ? ORDER BY YearOfWork";
    $statement = runQuery($pdo, $sql, array($id));
    return $statement;
}

/* Function that retrieves all museums by ID */
function readMuseums($id) {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM paintings INNER JOIN artists ON (paintings.ArtistID = artists.ArtistID) INNER JOIN galleries ON (paintings.GalleryID = galleries.GalleryID) WHERE paintings.GalleryID = ? ORDER BY YearOfWork";
    $statement = runQuery($pdo, $sql, array($id));
    return $statement;
}

/* Function that retrieves all shapes by ID */
function readShapes($id) {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM paintings INNER JOIN artists ON (paintings.ArtistID = artists.ArtistID) INNER JOIN galleries ON (paintings.GalleryID = galleries.GalleryID) WHERE paintings.ShapeID = ? ORDER BY YearOfWork";
    $statement = runQuery($pdo, $sql, array($id));
    return $statement;
}

/* Function that retrieves 20 paintings from the Paintings, Artists and Galleries table */
function readSelectedPaintings() {
    $sql = "SELECT * FROM paintings INNER JOIN artists ON (paintings.ArtistID = artists.ArtistID) INNER JOIN galleries ON (paintings.GalleryID = galleries.GalleryID) ORDER BY YearOfWork LIMIT 20";
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}

/* Function that retrieves a single painting from the Artists table by ID */
function readSinglePainting($id) {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM paintings INNER JOIN artists ON (paintings.ArtistID = artists.ArtistID) INNER JOIN galleries ON (paintings.GalleryID = galleries.GalleryID) WHERE paintings.PaintingID = ?";
    $statement = runQuery($pdo, $sql, array($id));
    return $statement;
}

/* Function that retrieves the painting review from the reviews table by ID */
function readReviews($id) {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM reviews WHERE PaintingID = ?";
    $statement = runQuery($pdo, $sql, [$id]);
    return $statement;
}

/* Function retrieves the individual review star rating in the reviews tab for a single painting */
function reviewStars($review) {
    $output = "";
    for ($i = 0; $i < $review; $i++) {
      echo '<i class="star icon"></i>';
    }
    for ($i = $review; $i < 5; $i++) {
      echo '<i class="empty star icon"></i>';
    }
    return $output;
}

/* Function retrieves the overall review star rating for a single painting */
function reviewOrangeStars($rating) {
    $output = "";
    for ($i=0; $i<$rating; $i++) {
      echo '<i class="orange star icon"></i>';
    }
    for ($i=$rating; $i<5; $i++) {
      echo '<i class="empty star icon"></i>';
    }
    return $output;
}

/* Function retrieves the average star rating for a specified painting */
function determineAverage($id){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT AVG(Rating) FROM reviews GROUP BY PaintingID HAVING PaintingID = ?";
    $result = runQuery($pdo, $sql, [$id]);
    $result = $result->fetch();
    return $result[0];
}    

/* Function that retrieves the painting genre from the painting genres table */
function readPaintingGenre($id) {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM paintings INNER JOIN paintinggenres ON (paintings.PaintingID = paintinggenres.PaintingID) INNER JOIN genres ON (paintinggenres.GenreID = genres.GenreID) WHERE paintings.PaintingID = ?";
    $statement = runQuery($pdo, $sql, array($id));
    return $statement;
}

/* Function that retrieves the painting subject from the painting subjects table */
function readPaintingSubject($id){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM paintings INNER JOIN paintingsubjects ON paintings.paintingID = paintingsubjects.paintingID INNER JOIN subjects ON paintingsubjects.SubjectID = subjects.SubjectID WHERE paintings.PaintingID = ?";
    $statement = runQuery($pdo, $sql, [$id]);
    return $statement;
}

/* Function that retrieves painting frame type from the typesframe table */
function readTypesFrame() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM typesframes ORDER BY FrameID";
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}

/* Function that retrieves painting glass type from the typesglass table */
function readTypesGlass() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM typesglass ORDER BY GlassID";
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}

/* Function that retrieves painting matt type from the typesmatt table */
function readTypesMatt() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $sql = "SELECT * FROM typesmatt ORDER BY MattID";
    $statement = runQuery($pdo, $sql, array());
    return $statement;
}  
?>