<?php
include "../config.php";
try{
$pdo = new PDO(DSN , DBUSER, DBPSWD);
if ($result = $pdo->query("SHOW TABLES LIKE 'users'")){
  if ($result->rowCount()){
    echo"停止";
    exit();
    $pdo->query('DROP TABLE users;');
  }
}
if ($result = $pdo->query("SHOW TABLES LIKE 'profile'")){
  if ($result->rowCount()){
    echo"停止";
    exit();
    $pdo->query('DROP TABLE profile;');
  }
}
if ($result = $pdo->query("SHOW TABLES LIKE 'post'")){
  if ($result->rowCount()){
    echo"停止";
    exit();
    $pdo->query('DROP TABLE post;');
  }
}
  if ($result = $pdo->query("SHOW TABLES LIKE 'route'")){
    if ($result->rowCount()){
      echo"停止";
      exit();
      $pdo->query('DROP TABLE route;');
    }
}

$pdo->query('CREATE TABLE users (uid VARCHAR(50), gid VARCHAR(50), AccountType VARCHAR(10), email VARCHAR(256), salt VARCHAR(12), create_at DATETIME);');
$pdo->query('CREATE TABLE profile (uid VARCHAR(50) ,name VARCHAR(14), icon VARCHAR(20), msg VARCHAR(2000), update_at DATETIME);');
$pdo->query('CREATE TABLE post (oid INT AUTO_INCREMENT NOT NULL PRIMARY KEY , pid VARCHAR(50), uid VARCHAR(50), post_title VARCHAR(2000), post_contents VARCHAR(2000), stat INT, is_deadline INT,deadline_at DATETIME, update_at DATETIME, create_at DATETIME);');
$pdo->query('CREATE TABLE route (pid VARCHAR(50) ,no INT, lat VARCHAR(10), lng VARCHAR(10), update_at DATETIME);');


$pdo->query('SET NAMES utf8');
$pdo->query('INSERT INTO users (uid, gid, AccountType, email, salt, create_at) VALUES (1, 11, "Google", "not@not", "salt", now());');

$pdo->query('INSERT INTO profile (uid, name, icon, msg, update_at) VALUES (1, "お試しアカウント"  , "user.png", "あ", now());');


    print('作成に成功しました。<br>');
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
}

unset($pdo);
 ?>
test
