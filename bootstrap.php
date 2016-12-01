<?php

// Load the SQL Schema if the database is empty

$dsn=getenv('DATABASE_URL');
preg_match( '|([a-z0-9]+)://([^:]*)(:(.*))?@([A-Za-z0-9\.-]*)(:([0-9]*))?(/([0-9a-zA-Z_/\.-]*))|', $dsn, $matches);

$db_host = $matches[5];
$db_user = $matches[2];
$db_pass = $matches[4];
$db_name = $matches[9];

$dsn = "mysql:host=$db_host;dbname=$db_name";
$db = new PDO($dsn, $db_user, $db_pass);
$res = $db->query("SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='$db_name'")->fetch(PDO::FETCH_NUM);

if ($res[0] == 0) {
    print "Loading schema...";
    $sql = file_get_contents('/var/www/html/SQL/mysql.initial.sql');
    $qr = $db->exec($sql);
    print "$qr";
} else {
    print "Database exists.";
}
?>
