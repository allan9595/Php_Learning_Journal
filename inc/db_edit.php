<?php
    
        function parseDate($date)
        {
            $date_array = explode("-",$date);
            $month = intval($date_array[1]);
            $year = intval($date_array[0]);
            $day = intval($date_array[2]);
            if($year<1900 || $year>date('Y')){
                return "Year is not valid, must be a year later than 1990 and less than 2019";
            }else{
                return checkdate($month, $day, $year);
            }
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
        $date = date_format(new DateTime($_POST["date"]), 'Y-m-d');
        $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
        $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
        $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
        $tag = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);
        //validation for the input field 

        //if there are empty, throw error msg
        session_start();
        if(
            $title == "" ||
            $time_spent == "" ||
            $learned == "" ||
            parseDate($date) === "Year is not valid, must be a year later than 1990 and less than 2019"
        ){ 
            $errors = ['title' => $title, 'date' => parseDate($date), 'time_spent' => $time_spent, 'learned'=>$learned];
            foreach($errors as $key => $value){
                if($value == ""){
                    $_SESSION['error'][$key] = "$key is required!";
                }

                if($value == "Year is not valid, must be a year later than 1990 and less than 2019"){
                    $_SESSION['error'][$key] = $value;
                }
            }
            header('Location: ../edit.php?id=' . $id);
        }else{
        function db_edit(){
            try{
                //update the entry first
                include('db_connection.php');
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                $title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
                $date = date_format(new DateTime($_POST["date"]), 'Y-m-d');
                $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
                $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
                $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
                $tag = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);



                $sql = "UPDATE entries SET `title` = ?, `date`= ?, `time_spent` = ?, 'learned' = ?, 'resources' = ? WHERE `id` = ?";
                $pdo = $db->prepare($sql);
                $pdo->bindValue(1, $title, PDO::PARAM_STR);
                $pdo->bindValue(2, $date, PDO::PARAM_STR);
                $pdo->bindValue(3, $time_spent, PDO::PARAM_STR);
                $pdo->bindValue(4, $learned, PDO::PARAM_STR);
                $pdo->bindValue(5, $resources, PDO::PARAM_STR);
                $pdo->bindValue(6, $id, PDO::PARAM_INT);
                $pdo->execute();

                if(isset($tag)){

                    //if mutiple tags entered, explode them by ',' then add them to db
                    if(strpos($tag, ',') == true){
                        //delete the tags name from tag table
                        $sql = "
                            DELETE FROM tags WHERE tags.id IN (select tag_id from entries_tags where entry_id = ?);
                        ";
                        $pdo = $db->prepare($sql);
                        $pdo->bindValue(1, $id, PDO::PARAM_INT);
                        $pdo->execute();

                        //delete the assocuate id number form third many-to-many table
                        $sql = "
                            DELETE FROM entries_tags WHERE entry_id = ?;
                        ";
                        $pdo = $db->prepare($sql);
                        $pdo->bindValue(1, $id, PDO::PARAM_INT);
                        $pdo->execute();

                        //split the tag with comma ',', then loop through the tag array to add those tags into db
                        $tag = explode(',', $tag);
                        foreach ($tag as $value) {
                            $value = trim($value);
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
                            $pdo->bindValue(1, $id, PDO::PARAM_INT);
                            $pdo->bindValue(2, $tag_id, PDO::PARAM_INT);
                            $pdo->execute();
                        }
                    }else{
                        //delete the tags name from tag table
                        $sql = "
                            DELETE FROM tags WHERE tags.id IN (select tag_id from entries_tags where entry_id = ?);
                        ";
                        $pdo = $db->prepare($sql);
                        $pdo->bindValue(1, $id, PDO::PARAM_INT);
                        $pdo->execute();

                        //delete the assocuate id number form third many-to-many table
                        $sql = "
                            DELETE FROM entries_tags WHERE entry_id = ?;
                        ";
                        $pdo = $db->prepare($sql);
                        $pdo->bindValue(1, $id, PDO::PARAM_INT);
                        $pdo->execute();
            
                        //re-insert the edited tag
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
                        $pdo->bindValue(1, $id, PDO::PARAM_INT);
                        $pdo->bindValue(2, $tag_id, PDO::PARAM_INT);
                        $pdo->execute();
                    }    
                }
                //if no tag inputed, just delete all the records
                if(empty($tag)){
                    //delete the tags name from tag table
                    $sql = "
                        DELETE FROM tags WHERE tags.id IN (select tag_id from entries_tags where entry_id = ?);
                    ";
                    $pdo = $db->prepare($sql);
                    $pdo->bindValue(1, $id, PDO::PARAM_INT);
                    $pdo->execute();

                    //delete the assocuate id number form third many-to-many table
                    $sql = "
                        DELETE FROM entries_tags WHERE entry_id = ?;
                    ";
                    $pdo = $db->prepare($sql);
                    $pdo->bindValue(1, $id, PDO::PARAM_INT);
                    $pdo->execute();

                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
            header('Location: ../detail.php?id=' . $id);
        }
        db_edit();
    }
   
?>