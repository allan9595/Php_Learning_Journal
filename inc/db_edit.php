<?php
    function db_edit(){
        include('db_connection.php');
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
        $date = date_format(new DateTime($_POST["date"]), 'Y-m-d');
        $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
        $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
        $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);

        $sql = "UPDATE entries SET `title` = ?, `date`= ?, `time_spent` = ?, 'learned' = ?, 'resources' = ? WHERE `id` = ?";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $title, PDO::PARAM_STR);
        $pdo->bindValue(2, $date, PDO::PARAM_STR);
        $pdo->bindValue(3, $time_spent, PDO::PARAM_STR);
        $pdo->bindValue(4, $learned, PDO::PARAM_STR);
        $pdo->bindValue(5, $resources, PDO::PARAM_STR);
        $pdo->bindValue(6, $id, PDO::PARAM_INT);
        $pdo->execute();
        header('Location: ../detail.php?id=' . $id);
    };

    db_edit();
   
?>