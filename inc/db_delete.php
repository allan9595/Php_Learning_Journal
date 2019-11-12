<?php
    function db_delete(){
        include('db_connection.php');
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $sql = "DELETE FROM `entries` WHERE `id` = ? ";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $id, PDO::PARAM_INT);
        $pdo->execute();
        header('Location: ../index.php');
    }
    db_delete();
?>