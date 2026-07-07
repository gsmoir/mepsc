<?php

echo 'PHP Version: ' . PHP_VERSION . '<br>';

echo 'SQLite3 loaded: ';
var_dump(extension_loaded('sqlite3'));

echo '<br>PDO SQLite loaded: ';
var_dump(extension_loaded('pdo_sqlite'));

echo '<br>SQLite3 class exists: ';
var_dump(class_exists('SQLite3'));