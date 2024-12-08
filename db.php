<?php
    require_once('dbfunctions.php');

    //db.php
    $host='localhost';
    $dbname='test';
    $user = 'root';
    $pass='';

    $options = [
        //throws errors from PDO
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //retrieves the user data as an associative array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //do not use prepared queries
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    //this is a function, the parameteres are 
    //you want to only open ONE conection to the DB per request
    $db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8mb4',$user,$pass,$options);
?>