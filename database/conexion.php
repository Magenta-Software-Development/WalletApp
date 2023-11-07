<?php

function getCon()
{
    require_once '../config/config.php';

    try {
        $con = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER,  PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->exec("SET CHARACTER SET " . DB_CHARSET);

        return $con;
    } catch (Exception $e) {
        print "Error: " . $e->getMessage()  . "<br>";
        die();
    }
}
