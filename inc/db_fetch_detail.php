<?php
    function db_fetch_detail(){
        include('db_connection.php');
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM `entries` WHERE `id` = ?";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $id, PDO::PARAM_INT);
        $pdo->execute();
        $results = $pdo->fetch(PDO::FETCH_ASSOC);
        return $results;
        
    }

?>