<?php
    function db_delete(){
        try{
            //delete the related entrie, tag, and many to many table id in the following order
            include('db_connection.php');
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $sql = "
                DELETE FROM entries WHERE id = ? 
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $id, PDO::PARAM_INT);
            $pdo->execute();

            $sql = "
                DELETE FROM tags WHERE id IN (select tag_id from entries_tags where entry_id = ?);
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $id, PDO::PARAM_INT);
            $pdo->execute();

            $sql = "
                DELETE FROM entries_tags WHERE entry_id = ?;
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $id, PDO::PARAM_INT);
            $pdo->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        header('Location: ../index.php');
    }
    db_delete();
?>