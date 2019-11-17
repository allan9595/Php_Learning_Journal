<?php
    function db_fetch_detail_no_tags(){
        try{
            //when no tag entered, just query the entries table
            include('db_connection.php');
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $sql = "
                SELECT * FROM entries WHERE entries.id = ?
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $id, PDO::PARAM_INT);
            $pdo->execute();
            $results = $pdo->fetch(PDO::FETCH_ASSOC);
            return $results;
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
    }

    function db_fetch_detail_with_tags(){
        try{
            //only query one entry since queried entries are indentical
            include('db_connection.php');
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $sql = "
                SELECT * FROM entries
                JOIN entries_tags ON entries.id = entry_id
                JOIN tags ON tags.id = tag_id
                WHERE entries_tags.entry_id = ? LIMIT 1;
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $id, PDO::PARAM_INT);
            $pdo->execute();
            $results = $pdo->fetch(PDO::FETCH_ASSOC);
            return $results;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function db_fetch_detail_get_tags(){
        try{
            //only fetch the tags for imploding
            include('db_connection.php');
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $sql = "
                SELECT tag_name FROM entries
                JOIN entries_tags ON entries.id = entry_id
                JOIN tags ON tags.id = tag_id
                WHERE entries_tags.entry_id = ? ;
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $id, PDO::PARAM_INT);
            $pdo->execute();
            $results = $pdo->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }


?>

