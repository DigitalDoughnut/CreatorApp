<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php 
  require_once 'functions.php';

  createTable('members',
              'user VARCHAR(16),
              pass VARCHAR(16),
              INDEX(user(6))');
  
  createTable('environments',
              'envname VARCHAR(32),
              envtype VARCHAR(16),
              userID VARCHAR(16),
              envdesc TEXT,
              INDEX(envname(6)),
              INDEX(envtype(6)),
              INDEX(userID(6))');

  createTable('messages', 
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');
  
  createTable('text_segments',
              'text_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              text_segment MEDIUMTEXT');
  
  createTable('characters',
              'char_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              char_name VARCHAR(16),
              INDEX (char_name (6))');
  
  createTable('biography',
              'biog_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              biog_text TEXT(16)');
  
  createTable ('projects',
               'proj_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                proj_name VARCHAR(16),
                proj_owner_id INT UNSIGNED,
                INDEX (proj_name (6))' );
  
  createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');
?>

    <br>...done.
  </body>
</html>
