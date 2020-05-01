<?php
return [
  "host" => "localhost",
  "name" => "task1",
  "user" => "root",
  "pass" => "",
  "opt" => array(
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES => false,
    \PDO::MYSQL_ATTR_FOUND_ROWS => true
  )
];
