<?php 
    function db_fetch(){
        include('db_connection.php');
        $sql = "SELECT `title`, `date` FROM `entries`";
        $pdo = $db->prepare($sql);
        $pdo->execute();
        $results = $pdo->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    };

?>