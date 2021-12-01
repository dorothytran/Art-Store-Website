<?php
// Dorothy Tran 101141902

    class PaintingInfo {
        public $paintingID;
        public $fileName;
        public $title;
        public $museumName;
        public $museumLink;
        public $accessionNum;
        public $copyrightText;
        public $description;
        public $exerpt;
        public $yearOfWork;
        public $width;
        public $height;
        public $medium;
        public $MSRP;
        public $googleLink;
        public $googleDescription;
        public $wikiLink;
        public $shape;

        function __construct($row) {
            $this->paintingID = $record['PaintingID'];
            $this->fileName= $record['ImageFileName'];
            $this->title= $record['Title'];
            $this->museumLink = $record['MuseumLink'];
            $this->accessionNum = $record['AccessionNumber'];
            $this->copyrightText = $record['CopyrightText'];
            $this->description = $record['Description'];
            $this->excerpt = $record['Excerpt'];
            $this->yearOfWork = $record['YearOfWork'];
            $this->width = $record['Width'];
            $this->height = $record['Height'];
            $this->medium = $record['Medium'];
            $this->MSRP = $record['MSRP'];
            $this->googleLink = $record['GoogleLink'];
            $this->googleDescription = $record['GoogleDescription'];
            $this->wikiLink = $record['WikiLink'];
            $this->shape = $record['ShapeName']; 
            $this->museumName = $record['GalleryName'];
        }
    }

    class ArtistInfo {
        public $artistLastName;
        function __construct($row) {
            $this->artistLastName = $record['LastName'];
        }
    }
    class Shapes {
        public $shapeName;
        function __construct($record){
            $this->shapeName = $record['ShapeName'];
        }
    }
    
    class Galleries {
        public $galleryName;
        function __construct($row) {
            $this->galleryName = $record['GalleryName'];
        }
    }

    class PaintingGenre {
        public $genreName;
        public $link;
        function __construct($record){
            $this->genreName = $record['GenreName'];
            $this->link = $record['Link'];
        }
    }

    class PaintingSubject {
        public $subjectName;
        function __construct($record){
            $this->subjectName = $record['SubjectName'];
        }
    }

    class Review {
        public $reviewDate;
        public $rating;
        public $comment;
        function __construct($record){
            $this->reviewDate = $record["ReviewDate"]; // fix format later
            $this->rating = $record['Rating'];
            $this->comment = $record['Comment'];
        }
    }
?>