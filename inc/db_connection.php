<?php
    try{
        //echo __DIR__ . "<br>";
        //echo dirname(__DIR__) . "<br>";
        $db = new PDO("sqlite:".dirname(__DIR__)."/inc/journal.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //var_dump($db);
    }catch(Exception $e){
        echo $e->getMessage();
        die();
    }
    
?>