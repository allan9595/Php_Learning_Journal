<?php
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    // /$date = strtotime($_POST["date"]);
    $date = date_format(new DateTime($_POST["date"]), 'Y-m-d');
    $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
    $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
    $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);

    function db_add(
        $title, 
        $date, 
        $time_spent,
        $learned,
        $resources
    ){
        include('db_connection.php');
        $sql = "INSERT INTO `entries` (`title`, `date`, `time_spent`, `learned`, `resources`) VALUES (?, ?, ?, ?, ?)";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $title, PDO::PARAM_STR);
        $pdo->bindValue(2, $date, PDO::PARAM_STR);
        $pdo->bindValue(3, $time_spent, PDO::PARAM_STR);
        $pdo->bindValue(4, $learned, PDO::PARAM_STR);
        $pdo->bindValue(5, $resources, PDO::PARAM_STR);
        $pdo->execute();
    }

    db_add($title, $date, $time_spent, $learned, $resources);
    header('Location: ../new.php');
?>