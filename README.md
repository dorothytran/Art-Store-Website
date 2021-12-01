# Art-Web-Store
## PHP, SQL, State Management & Caching


## DESCRIPTION
This simple art store website uses server-side programming with PHP, SQL, State Management, and Caching to create a web art store to display various paintings from around the world. The website uses PHP and SQL to populate the website with paintings while giving functionality to the filter drop-down menus, state management to allow users to select their favourite paintings when clicking on a button, and caching to store data.

The website consists of various main .php files:
* ```addToFavorites.php```
* ```browse-paintings.php```
* ```remove-favorites.php```
* ```single-painting.php```
* ```view-favorites.php```

The website is supported by various include files in the includes folder:
* ```art-classes.php```
* ```config.inc.php```
* ```header.inc.php```
* ```sql-database.inc.php```


## INSTALLATION
To successfully run the program, the user must have access to XAMPP & Memcached on a Windows/MacOS.
1. Download memcached and XAMPP onto your computer.
2. The user must have the art-small.sql database provided on Brightspace which is imported onto the phpMyAdmin database.
3. The user must be logged in with the correct credentials when creating a User Account.
	- User name (use text field): testuser
	- Host (Local): localhost
	- Password (use text field): mypassword
	- Re-Type: mypassword


## USAGE
1. Move the downloaded file into the directory path: C:\xampp\htdocs for the program to run.
2. After downloading XAMPP successfully onto your computer, open the XAMPP Control Panel.
3. On the XAMPP Control Panel, select the Start buttons for Apache and MySQL modules to run the program.
4. To run the web application, open the preffered web browser (Google Chrome, Microsoft Edge, etc) and type in the search bar: "localhost/Start/browse-paintings.php".
5. A web browser art store will appear onto your browser.

Features of the Web Application:
Users can interact with the web application by clicking parts of the web page that allows users to navigate throughout different web pages.

```browse-paintings.php```
* On the left Filters navigation tab, users will be able to filter through a list of Artists, Museums, and Shapes in the drop-downs which are populated from the SQL database provided. When clicking the filter button, the user will be able to view the filtered output list.
* Users will be able to click on the actual painting that is displayed and will direct them to a single-painting.php file based on the Painting ID.
* Users may click the heart icon under each painting as a favourite painting.
* By selecting Favorites on the top-right corner of the page, the user will be directed to the page: view-favorites.php which will list their favorited paintings.
![](Start/images/Capture3.PNG)

```single-painting.php```
* When the single painting display appears, users may view the title of the painting, artist, overall reviews, details, the museum it is placed in, the genre, the subject, the price and features of the painting.
* Users may click the 'Add to Favourites' icon under each painting as a favourite painting.
![](Start/images/Capture4.PNG)

```view-favorites.php```
* Users may view the list of favorited paintings.
* By selecting the 'Remove All Favorites' button, all paintings that have been favorited by the user will be removed from the list.
![](Start/images/Capture5.PNG)


## LICENSE
Copyright 2021 Dorothy Tran. All rights reserved.
