<?php 
    function db_fetch(){
        try{
            //select the unique entry and tag from db
            include('db_connection.php');
            $sql = "
                SELECT id, title, date FROM entries
            ";
            $pdo = $db->prepare($sql);
            $pdo->execute();
            $results = $pdo->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    };

    function db_fetch_tags_under_same_entry($id){
        try{
            //select the unique entry and tag from db
            include('db_connection.php');
            $sql = "
                SELECT tags.tag_name FROM entries
                LEFT jOIN entries_tags ON entries.id = entry_id
                LEFT JOIN tags on tags.id = tag_id
                WHERE entry_id = ?;
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

    function db_fetch_tags(){
        try{
            //query unique tag
            include('db_connection.php');
            $sql = "SELECT DISTINCT `tag_name` FROM `tags`";
            $pdo = $db->prepare($sql);
            $pdo->execute();
            $results = $pdo->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function db_fetch_filtered($filter){
        try{
            //filtered the tag based on its name
            include('db_connection.php');
            $sql = "
                SELECT entries.id, entries.title, entries.date FROM entries 
                JOIN entries_tags ON entries.id = entry_id
                JOIN tags ON tag_id = tags.id
                WHERE tag_name = ?
            "; 
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $filter, PDO::PARAM_STR);
            $pdo->execute();
            $results = $pdo->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

?>