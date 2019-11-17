<?php
    try{
        //connect to the db
        $db = new PDO("sqlite:".dirname(__DIR__)."/inc/journal.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        echo $e->getMessage();
        die();
    }
    
?>