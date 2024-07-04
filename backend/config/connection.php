<?php


$host = "localhost";
$pass = "";
$database ="instituto";
$user = "root";
$pdo =null;

 function connect(){
    try{
        $GLOBALS['pdo'] = new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['database']."", $GLOBALS['user'], $GLOBALS['pass']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        print "Error".$e->getMessage();
        die();
    }

}

 function close(){
    $GLOBALS['pdo']=null;
}