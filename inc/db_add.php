<?php
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $date = date_format(new DateTime($_POST["date"]), 'Y-m-d');
    $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
    $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
    $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
    $tag = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);

    function db_add(
        $title, 
        $date, 
        $time_spent,
        $learned,
        $resources,
        $tag
    ){
        try{
            //insert the new data
            include('db_connection.php');
            $sql = "
                INSERT INTO `entries` (`title`, `date`, `time_spent`, `learned`, `resources`) VALUES (?, ?, ?, ?, ?); 
            ";
            $pdo = $db->prepare($sql);
            $pdo->bindValue(1, $title, PDO::PARAM_STR);
            $pdo->bindValue(2, $date, PDO::PARAM_STR);
            $pdo->bindValue(3, $time_spent, PDO::PARAM_STR);
            $pdo->bindValue(4, $learned, PDO::PARAM_STR);
            $pdo->bindValue(5, $resources, PDO::PARAM_STR);
            $pdo->execute();

            //inspried by https://stackoverflow.com/questions/1735571/many-to-many-relationship-insert @James Skidmore
            $sql = "SELECT last_insert_rowid()";
            $pdo = $db->prepare($sql);
            $pdo->execute();
            $entries_array = $pdo->fetch(PDO::FETCH_ASSOC);
            $entries_id = $entries_array["last_insert_rowid()"];
        }catch(Exception $e){
            echo $e->getMessage();
        }

        //if mutiple tags entered, explode them by ',' then add them to db
        if(strpos($tag, ',') == true){
            $tag = explode(',', $tag);
            foreach ($tag as $value) {
                try{
                    //build the many to many replationship
                    $sql = "
                        INSERT INTO `tags` (`tag_name`) VALUES(?);
                    ";
                    $pdo = $db->prepare($sql);
                    $pdo->bindValue(1, $value, PDO::PARAM_STR);
                    $pdo->execute();

                    $sql = "SELECT last_insert_rowid()";
                    $pdo = $db->prepare($sql);
                    $pdo->execute();

                    $tag_array =$pdo->fetch(PDO::FETCH_ASSOC);
                    $tag_id = $tag_array["last_insert_rowid()"];
                    
                    $sql = "
                        INSERT INTO entries_tags (entry_id, tag_id) VALUES (?, ?);
                    ";
                    $pdo = $db->prepare($sql);
                    $pdo->bindValue(1, $entries_id, PDO::PARAM_STR);
                    $pdo->bindValue(2, $tag_id, PDO::PARAM_STR);
                    $pdo->execute();
                }catch(Exception $e){
                    echo $e->getMessage();
                }
    
            }
        }else{
            try{
                //if just one single tag entered at one time, then insert it directly
                $sql = "
                    INSERT INTO `tags` (`tag_name`) VALUES(?);
                ";
                $pdo = $db->prepare($sql);
                $pdo->bindValue(1, $tag, PDO::PARAM_STR);
                $pdo->execute();

                $sql = "SELECT last_insert_rowid()";
                $pdo = $db->prepare($sql);
                $pdo->execute();
                $tag_array =$pdo->fetch(PDO::FETCH_ASSOC);
                $tag_id = $tag_array["last_insert_rowid()"];
                
                $sql = "
                    INSERT INTO entries_tags (entry_id, tag_id) VALUES (?, ?);
                ";
                $pdo = $db->prepare($sql);
                $pdo->bindValue(1, $entries_id, PDO::PARAM_STR);
                $pdo->bindValue(2, $tag_id, PDO::PARAM_STR);
                $pdo->execute();
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }    
    }

    db_add($title, $date, $time_spent, $learned, $resources, $tag);
    header('Location: ../index.php');
?>