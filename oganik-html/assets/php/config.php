<?php
  /* 
  Database credentials. Assuming you are running MySQL
  server with default setting (user 'root' with no password) 

  https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
  */

  define('DB_SERVER', 'remotemysql.com');
  define('DB_USERNAME', 'IS5Ug9xYKL');
  define('DB_PASSWORD', 'BtSHNUjLsK');
  define('DB_NAME', 'IS5Ug9xYKL');
 
  /* Attempt to connect to MySQL database */
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
  // Check connection
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>